<?php

namespace App\Listeners;

use DB;
use Auth;
use App\User;
use App\Models\Package;
use App\Models\Status;
use App\Models\UserProgram;
use App\Models\Notification;
use App\Models\Program;
use App\Models\Country;
use App\Models\City;
use App\Facades\Balance;
use App\Facades\Hierarchy;
use App\Events\Activation;
use Carbon\Carbon;
use App\Models\Processing;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserActivated
{
    /**
     * Create the event listener.
     *
     */

    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  Activation  $event
     * @return void
     */
    public function handle(Activation $event)
    {
        $id = $event->user->id;
        $program = Program::find($event->user->program_id);
        $this_user = User::find($id);
        $inviter = User::find($event->user->inviter_id);
        $package = Package::find($event->user->package_id);
        $package_id = $package->id;
        $status_id = $package->rank;
        $package_cost = $package->cost;

        /*start check*/
        if(is_null($this_user)) dd("Пользователь не найден");
        $check_user_program = UserProgram::where('program_id', $program->id)->where('user_id',$id)->count();
        if($check_user_program != 0) dd("Пользователь уже активирован -> $id");
        /*end check*/

        /*start sponsor check*/
        $check_this_user_sponsor_id_program = UserProgram::where('program_id', $program->id)->where('user_id',$this_user->sponsor_id)->count();
        if($check_this_user_sponsor_id_program == 0) dd("Спонсор не активирован -> $this_user->sponsor_id");
        /*end sponsor check*/


        /*start init and activate*/
        /*set sponsor if sponsor not found*/
        if(is_null($this_user->sponsor_id)){
            $sponsor_data = Hierarchy::getSponsorId($inviter->id);
            $sponsor_id = $sponsor_data[0];
            $position_data = $sponsor_data[1];

            $checker = User::where('sponsor_id',$sponsor_id)->where('position',$position_data)->count();
            if($checker > 0) dd('status', 'Позиция занята, проверьте, есть не активированный партнер в этой позиции');
            else{

                User::find($id)->update([
                    'sponsor_id' => $sponsor_id,
                    'position' => $position_data,
                    'package_id' => $package_id,
                ]);
                $this_user = User::find($id);
            }
        }
        /*end set sponsor if sponsor not found*/

        if(!is_null($event->user->status_id) && $event->user->status_id != 0  && $status_id < $event->user->status_id){
            $status_id = $event->user->status_id;
        }

        $list = Hierarchy::getSponsorsList($event->user->id,'').',';
        $inviter_list = Hierarchy::getInviterList($event->user->id,'').',';


        $country_short_name = 'KZ';
        $city_code = '01';
        $user_country = Country::where('id',$this_user->country_id)->first();
        $user_city = City::where('id',$this_user->city_id)->first();

        if(is_null($user_country)){
            $country_short_name = $user_country->short;
        }

        if(is_null($user_city)){
            $city_code = $user_city->code;
        }

        $id_number = $country_short_name.$city_code.date('Ymd').$this_user->id;

        User::whereId($event->user->id)->update([
            'status' => 1,
        ]);

        if(is_null($this_user->id_number)){
            User::whereId($event->user->id)->update([
                'id_number' => $id_number
            ]);
        }


        /*set register sum */
        Balance::changeBalance($id,$package_cost+Hierarchy::registrationFee($package->id),'register',$event->user->id,$event->user->program_id,$package_id,0);

        UserProgram::insert(
            [
                'user_id' => $event->user->id,
                'list' => $list,
                'status_id' => $status_id,
                'inviter_list' => $inviter_list,
                'program_id' => $event->user->program_id,
                'package_id' => $package_id,
            ]
        );

        /*start activate sponsor binary*/
        $sponsor_subscribers =  UserProgram::join('users','user_programs.user_id','=','users.id')
            ->where('users.inviter_id',$this_user->inviter_id)
            ->where('users.status',1)
            ->count();
        if($sponsor_subscribers == 2) UserProgram::whereUserId($this_user->inviter_id)->update(['is_binary' => 1]);
        /*end activate sponsor binary*/

        if (Auth::check())
            $author_id = Auth::user()->id;
        else
            $author_id = 0;

        Notification::create([
            'user_id' => $event->user->id,
            'type' => 'user_activated',
            'author_id' => $author_id
        ]);

        /*end init and activate*/

        if($package_id != 0){
            $sponsors_list = explode(',',trim($list,','));

            /*start set  matching_bonus  */
            /*$inviter_list_for_lkb = explode(',',trim($inviter_list,','));
            $inviter_list_for_lkb = array_slice($inviter_list_for_lkb, 0, 7);
            $old_max_status_percentage = 0;

            foreach ($inviter_list_for_lkb as $key_matching => $item_matching){

                $matching_user_program = UserProgram::where('user_id',$item_matching)->first();

                if(!is_null($matching_user_program)){
                    $new_max_status_percentage = Status::find($matching_user_program->status_id)->matching_bonus;

                    if($matching_user_program->package_id == 2 and $new_max_status_percentage < 5) {
                        $new_max_status_percentage = 5;
                    }

                    if($matching_user_program->package_id == 3 and $new_max_status_percentage < 10) {
                        $new_max_status_percentage = 10;
                    }

                    if($new_max_status_percentage > $old_max_status_percentage){

                        $current_max_status_percentage = $new_max_status_percentage - $old_max_status_percentage;
                        $old_max_status_percentage = $new_max_status_percentage;

                        Balance::changeBalance($item_matching,$package->cost*$current_max_status_percentage/100,'matching_bonus',$id,$program->id,$package->id,'',$package->pv,'',$key_matching);
                    }
                }
            }*/
            /*end set  matching_bonus  */


            foreach ($sponsors_list as $key => $item){

                $item_user_program = UserProgram::where('user_id',$item)->first();

                if(!is_null($item_user_program)){

                    $item_status = Status::find($item_user_program->status_id);
                    $item_package = Package::find($item_user_program->package_id);

                    /*set own pv and change status*/
                    $position = 0;

                    if((count($sponsors_list) == 1 && $item == 1) || $key == 0){
                        $position = $this_user->position;
                    }
                    elseif(count($sponsors_list) == 2 && $item == 1){
                        $position = User::where('id',$sponsors_list[0])->where('status',1)->first()->position;
                    }else{

                        $current_user_first = User::where('id',$sponsors_list[$key-1])->where('position',1)->first();
                        $current_user_second =  User::where('id',$sponsors_list[$key-1])->where('position',2)->first();

                        if(!is_null($current_user_first) && strpos($list, ','.$current_user_first->id.',') !== false) $position = 1;
                        if(!is_null($current_user_second) && strpos($list, ','.$current_user_second->id.',') !== false) $position = 2;
                    }

                    /*if($item_user_program->is_binary == 1 or $this_user->inviter_id == $item_user_program->user_id){
                        Balance::setQV($item,$package->pv,$id,$package->id,$position,$item_status->id);
                    }
                    else{
                        Balance::setQV($item,0,$id,$package->id,$position,$item_status->id);
                    }*/
                    Balance::setQV($item,$package->pv,$id,$package->id,$position,$item_status->id, '',$item_user_program->is_binary);

                    //start check small branch definition
                    $left_user = User::whereSponsorId($item)->wherePosition(1)->whereStatus(1)->first();
                    $right_user = User::whereSponsorId($item)->wherePosition(2)->whereStatus(1)->first();
                    $left_pv = Hierarchy::pvCounter($item,1);
                    $right_pv = Hierarchy::pvCounter($item,2);
                    if($left_pv > $right_pv) $small_branch_position = 2;
                    else $small_branch_position = 1;
                    //end check small branch definition

                    //start check next status conditions and move
                    $pv = Hierarchy::pvCounter($item,$small_branch_position);

                    $next_status = Status::find($item_status->order+1);


                    if(!is_null($left_user) && !is_null($right_user)){

                        if(!is_null($next_status)){
                            //$prev_statuses_pv = Status::where('order','<=',$next_status->order)->sum('pv');
                            $prev_statuses_pv = $next_status->pv;
                            if($prev_statuses_pv <= $pv){ // && count(Hierarchy::followersList($item)) <= $next_status->condition

                                if($item_user_program->is_binary == 1){
                                    $needed_upgrade = true;

                                    if($next_status->id == 5 && $item_user_program->package_id >= 2){
                                        $needed_upgrade = false;
                                    }

                                    if($next_status->id == 7 && $item_user_program->package_id >= 3){
                                        $needed_upgrade = false;
                                    }

                                    if($item_user_program->package_id == 5 or $item_user_program->package_id == 6){
                                        $needed_upgrade = false;
                                    }


                                    if($next_status->id > 2){
                                        $status_condition_count = UserProgram::where('inviter_list','like','%,'.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,$item_user_program->status_id)
                                            ->count();

                                        if($status_condition_count >= 2) $status_condition = true;
                                        else $status_condition = false;

                                    }
                                    else $status_condition = true;


                                    if($needed_upgrade && $status_condition){
                                        Hierarchy::moveNextStatus($item,$next_status->id,$item_user_program->program_id);
                                        $item_user_program = UserProgram::where('user_id',$item)->first();
                                        $item_status = Status::find($item_user_program->status_id);
                                        Balance::changeBalance($item,$item_status->status_bonus,'status_bonus',$id,$program->id,$item_user_program->package_id,$item_status->id);


                                        Notification::create([
                                            'user_id'   => $item,
                                            'type'      => 'move_status',
                                            'status_id' => $item_user_program->status_id
                                        ]);
                                    }

                                }
                            }
                        }
                    }
                    //end check next status conditions and move

                    /*start set  turnover_bonus  */


                    if($item_user_program->package_id != 5){
                        $credited_pv = Processing::where('status','turnover_bonus')->where('user_id',$item)->sum('pv');
                        $credited_sum = Processing::where('status','turnover_bonus')->where('user_id',$item)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('sum');

                        if($small_branch_position == 1){
                            $to_enrollment_pv = $left_pv - $credited_pv;
                        }
                        else
                            $to_enrollment_pv = $right_pv - $credited_pv;

                        $sum = $to_enrollment_pv*$item_status->turnover_bonus/100;
                        echo 'sum->'.$credited_sum.'<br>';
                        echo 'sum->'.$item_status->week_sum_limit.'<br>';
                        if($credited_sum < $item_status->week_sum_limit){
                            $temp_sum = 0;
                            if($credited_sum + $sum >  $item_status->week_sum_limit){
                                $temp_sum = $item_status->week_sum_limit-$credited_sum;
                                $temp_sum = $sum - $temp_sum;
                                $sum = $sum - $temp_sum;
                            }
                            echo 'sum->'.$sum.'<br>';

                            if($item_user_program->is_binary == 0){
                                $sum = 0;
                            }

                            Balance::changeBalance($item,$sum,'turnover_bonus',$id,$program->id,$package->id,$item_status->id,$to_enrollment_pv,$temp_sum);

                            /*start set  matching_bonus  */
                            if($item_package->id == 1 or $item_package->id == 2 or $item_package->id == 3){

                                $inviter_list_for_matching = explode(',',trim($item_user_program->inviter_list,','));
                                $inviter_list_for_matching = array_slice($inviter_list_for_matching, 0, 3);

                                foreach ($inviter_list_for_matching as $key_referral => $item_matching){

                                    if($item_matching != ""){

                                        $item_matching_user_program = UserProgram::where('user_id',$item_matching)->first();


                                        if($item_matching_user_program->package_id == 2 or $item_matching_user_program->package_id == 3 or $item_matching_user_program->status_id >= 2){

                                            if($key_referral == 0  && $item_matching_user_program->status_id >= 2){
                                                Balance::changeBalance($item_matching,$sum*10/100,'matching_bonus',$item,$program->id,$package->id,'',$package->pv,'',$key_referral,$id);

                                            }

                                            if($key_referral == 1  && ($item_matching_user_program->package_id == 2 or $item_matching_user_program->package_id == 3)){
                                                Balance::changeBalance($item_matching,$sum*10/100,'matching_bonus',$item,$program->id,$package->id,'',$package->pv,'',$key_referral,$id);

                                            }

                                            if($key_referral == 2  && $item_matching_user_program->package_id == 3){
                                                Balance::changeBalance($item_matching,$sum*10/100,'matching_bonus',$item,$program->id,$package->id,'',$package->pv,'',$key_referral,$id);

                                            }
                                        }
                                    }
                                }
                            }
                            /*end set  matching_bonus  */

                        }
                        else {
                            Balance::changeBalance($item,0,'turnover_bonus',$id,$program->id,$package->id,$item_status->id,$to_enrollment_pv,$sum);
                        }
                    }

                    /*end set  turnover_bonus  */
                }
            }

            /*start set  invite_bonus  */
            if($package_id != 5){
                $inviter_list_for_referral = explode(',',trim($inviter_list,','));
                $inviter_list_for_referral = array_slice($inviter_list_for_referral, 0, 2);

                foreach ($inviter_list_for_referral as $key_referral => $item_referral){

                    if($key_referral == 0 && $item_referral != ""){
                        Balance::changeBalance($item_referral,$package->cost*$package->invite_bonus/100,'invite_bonus',$id,$program->id,$package->id,'',$package->pv);
                    }
                    /*
                    if($key_referral == 1){
                        Balance::changeBalance($item_referral,$package->cost*$package->vip_invite_bonus/100,'invite_bonus',$id,$program->id,$package->id,'',$package->pv);

                    }*/
                }
            }
            /*end set  invite_bonus  */


        }

    }
}
