<?php

namespace App\Listeners;


use App\Models\Processing;
use DB;
use Auth;
use App\User;
use App\Models\Order;
use App\Models\Counter;
use App\Models\Package;
use App\Models\Status;
use App\Models\UserProgram;
use App\Models\Notification;
use App\Models\Program;
use App\Facades\Balance;
use App\Facades\Hierarchy;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Events\Upgrade;

class UserUpgraded
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Upgrade  $event
     * @return void
     */
    public function handle(Upgrade $event)
    {

        $id = $event->order->user_id;
        $this_user = User::find($id);
        $inviter = User::find($this_user->inviter_id);
        $package = Package::find($this_user->package_id);
        $package_id = $package->id;
        $status_id = $package->rank;
        $package_cost = $package->cost;
        $program = Program::find($this_user->program_id);

        /*start check*/
        if($package->id == $event->order->package_id) dd("Пакет уже апгрейден");
        /*end check*/

        Balance::changeBalance($id,$event->order->amount,'register',$this_user->id,$this_user->program_id,$package_id,0);


        UserProgram::where('user_id',$id)
            ->update([
                'package_id' => $event->order->package_id
            ]);

        User::where('id',$id)
            ->update([
            'package_id' => $event->order->package_id
        ]);

        $new_package = Package::find($event->order->package_id);

        if (Auth::check())
            $author_id = Auth::user()->id;
        else
            $author_id = 0;

        Notification::create([
            'user_id' => $this_user->id,
            'type' => 'user_upgraded',
            'author_id' => $author_id
        ]);

        $user_program = UserProgram::where('user_id',$id)->first();
        $list = $user_program->list;

        $sponsors_list = explode(',',trim($user_program->list,','));

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

                                if($next_status->id == 2){
                                    if (!in_array($item_user_program->package_id, [1,2,3])) $needed_upgrade = false;
                                }

                                if($next_status->id == 3){
                                    if (!in_array($item_user_program->package_id, [1,2,3])) $needed_upgrade = false;
                                    else{
                                        $small_branch_user = User::where('sponsor_id',$item_user_program->user_id)->where('position',$small_branch_position)->first();

                                        $status_condition_count1 = UserProgram::where('list','like','%,'.$small_branch_user->id.','.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,2)
                                            ->count();

                                        $status_condition_count2 = UserProgram::where('user_id', $small_branch_user->id)->count();

                                        $status_condition_count = $status_condition_count1 + $status_condition_count2;

                                        if($status_condition_count == 0) $needed_upgrade = false;
                                    }
                                }

                                if($next_status->id == 4){
                                    if (!in_array($item_user_program->package_id, [1,2,3])) $needed_upgrade = false;
                                    else{
                                        $status_condition_count2 = UserProgram::where('list','like','%,'.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,2)
                                            ->take(1)
                                            ->get();

                                        $status_condition_count3 = UserProgram::where('list','like','%,'.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,3)
                                            ->take(1)
                                            ->get();

                                        if(count($status_condition_count2)+count($status_condition_count3) < 2) $needed_upgrade = false;

                                    }
                                }

                                if($next_status->id == 5){
                                    if (!in_array($item_user_program->package_id, [1,2,3])) $needed_upgrade = false;
                                    else{
                                        $status_condition_count = UserProgram::where('list','like','%,'.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,4)
                                            ->count();

                                        if($status_condition_count == 0) $needed_upgrade = false;
                                    }
                                }

                                if($next_status->id == 6){
                                    if (!in_array($item_user_program->package_id, [2,3])) $needed_upgrade = false;
                                    else{
                                        $status_condition_count4 = UserProgram::where('list','like','%,'.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,4)
                                            ->take(1)
                                            ->get();

                                        $status_condition_count6 = UserProgram::where('list','like','%,'.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,5)
                                            ->take(1)
                                            ->get();

                                        if(count($status_condition_count4)+count($status_condition_count6) < 2) $needed_upgrade = false;
                                    }
                                }

                                if($next_status->id == 7){
                                    if (!in_array($item_user_program->package_id, [2,3])) $needed_upgrade = false;
                                    else{
                                        $status_condition_count = UserProgram::where('list','like','%,'.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,6)
                                            ->count();

                                        if($status_condition_count == 0) $needed_upgrade = false;
                                    }
                                }

                                if($next_status->id == 8){
                                    if (!in_array($item_user_program->package_id, [3])) $needed_upgrade = false;
                                    else{
                                        $status_condition_count6 = UserProgram::where('list','like','%,'.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,6)
                                            ->count();

                                        $status_condition_count7 = UserProgram::where('list','like','%,'.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,7)
                                            ->count();

                                        if(count($status_condition_count6)+count($status_condition_count7) < 2) $needed_upgrade = false;
                                    }
                                }

                                if($next_status->id == 9){
                                    if (!in_array($item_user_program->package_id, [3])) $needed_upgrade = false;
                                    else{
                                        $status_condition_count = UserProgram::where('list','like','%,'.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,8)
                                            ->count();

                                        if($status_condition_count == 0) $needed_upgrade = false;
                                    }

                                }

                                if($next_status->id == 10){
                                    if (!in_array($item_user_program->package_id, [3])) $needed_upgrade = false;
                                    else{
                                        $status_condition_count = UserProgram::where('list','like','%,'.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,8)
                                            ->count();

                                        if($status_condition_count < 2) $needed_upgrade = false;
                                    }
                                }

                                if($next_status->id == 11){
                                    if (!in_array($item_user_program->package_id, [3])) $needed_upgrade = false;
                                    else{
                                        $status_condition_count8 = UserProgram::where('list','like','%,'.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,8)
                                            ->count();

                                        $status_condition_count9 = UserProgram::where('list','like','%,'.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,9)
                                            ->count();

                                        if(count($status_condition_count8)+count($status_condition_count9) < 2) $needed_upgrade = false;
                                    }
                                }

                                if($next_status->id == 12){
                                    if (!in_array($item_user_program->package_id, [3])) $needed_upgrade = false;
                                    else{
                                        $status_condition_count9 = UserProgram::where('list','like','%,'.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,9)
                                            ->count();

                                        $status_condition_count10 = UserProgram::where('list','like','%,'.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,10)
                                            ->count();

                                        if(count($status_condition_count9)+count($status_condition_count10) < 2) $needed_upgrade = false;
                                    }
                                }

                                if($next_status->id == 13){
                                    if (!in_array($item_user_program->package_id, [3])) $needed_upgrade = false;
                                    else{
                                        $status_condition_count = UserProgram::where('list','like','%,'.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,11)
                                            ->count();

                                        if($status_condition_count < 2) $needed_upgrade = false;
                                    }
                                }


                                //if($needed_upgrade){ //условии убраны
                                    Hierarchy::moveNextStatus($item,$next_status->id,$item_user_program->program_id);
                                    $item_user_program = UserProgram::where('user_id',$item)->first();
                                    $item_status = Status::find($item_user_program->status_id);
                                    //Balance::changeBalance($item,$item_status->status_bonus,'status_bonus',$id,$program->id,$item_user_program->package_id,$item_status->id);
                                    Balance::changeBalance($item,$item_status->cashback_bonus,'cashback',$id,$program->id,$item_user_program->package_id,$item_status->id);


                                    Notification::create([
                                        'user_id'   => $item,
                                        'type'      => 'move_status',
                                        'status_id' => $item_user_program->status_id
                                    ]);
                                //}

                            }
                        }
                    }

                    /*start set  turnover_bonus  */
                    if($item_user_program->package_id != 4 && $item_user_program->is_binary == 1){
                        $credited_pv = Processing::where('status','turnover_bonus')->where('user_id',$item)->sum('pv');
                        $credited_sum = Processing::where('status','turnover_bonus')->where('user_id',$item)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('sum');

                        if($small_branch_position == 1){
                            $to_enrollment_pv = $left_pv - $credited_pv;
                        }
                        else
                            $to_enrollment_pv = $right_pv - $credited_pv;

                        $sum = $to_enrollment_pv*$item_package->turnover_bonus/100;

                        if($credited_sum < $item_status->week_sum_limit){
                            $temp_sum = 0;
                            if($credited_sum + $sum >  $item_status->week_sum_limit){
                                $temp_sum = $item_status->week_sum_limit-$credited_sum;
                                $temp_sum = $sum - $temp_sum;
                                $sum = $sum - $temp_sum;
                            }


                            Balance::changeBalance($item,$sum,'turnover_bonus',$id,$program->id,$package->id,$item_status->id,$to_enrollment_pv,$temp_sum);
                            Balance::changeBalance($item,$sum*0.2,'cashback',$id,$program->id,$package->id,$item_status->id,$to_enrollment_pv,$temp_sum);


                            /*start set  matching_bonus  */
                            $inviter_list_for_matching = explode(',',trim($item_user_program->inviter_list,','));
                            $inviter_list_for_matching = array_slice($inviter_list_for_matching, 0, 3);

                            foreach ($inviter_list_for_matching as $key_referral => $item_matching){

                                if($item_matching != ""){

                                    $item_matching_user_program = UserProgram::where('user_id',$item_matching)->first();


                                    if($key_referral == 0  && ($item_matching_user_program->package_id == 2 or $item_matching_user_program->package_id == 3)){
                                        Balance::changeBalance($item_matching,$sum*10/100,'matching_bonus',$item,$program->id,$package->id,'',$package->pv,'',$key_referral,$id);

                                    }

                                    if($key_referral == 1  && ($item_matching_user_program->package_id == 2 or $item_matching_user_program->package_id == 3)){
                                        Balance::changeBalance($item_matching,$sum*5/100,'matching_bonus',$item,$program->id,$package->id,'',$package->pv,'',$key_referral,$id);

                                    }

                                    if($key_referral == 2  && $item_matching_user_program->package_id == 3){
                                        Balance::changeBalance($item_matching,$sum*5/100,'matching_bonus',$item,$program->id,$package->id,'',$package->pv,'',$key_referral,$id);

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
                //end check next status conditions and move

            }
        }



        /*start set  invite_bonus  */
        if($package_id != 4){

            $inviter_package = Package::find($inviter->package_id);

            Balance::changeBalance($inviter->id,$event->order->amount*$inviter_package->invite_bonus/100,'invite_bonus',$id,$program->id,$package->id,'',$package->pv);
            Balance::changeBalance($id,$event->order->amount*0.4,'cashback',$id,$program->id,$package->id,'',$package->pv);

        }
        /*end set  invite_bonus  */

    }
}
