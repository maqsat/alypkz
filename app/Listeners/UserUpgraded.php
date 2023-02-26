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

        $list = explode(',',trim($user_program->list,','));

        foreach ($list as $key => $item){
            if($key == 0 && $item != ""){
                Balance::changeBalance($item,$event->order->amount*$package->invite_bonus/100,'invite_bonus',$id,$program->id,$package->id,'',$package->pv);
                Balance::changeBalance($id,$event->order->amount*0.4,'cashback',$id,$program->id,$package->id,'',$package->pv);

            }
                //start check small branch definition
                $left_pv = Hierarchy::pvCounter($item,1);
                $right_pv = Hierarchy::pvCounter($item,2);
                if($left_pv > $right_pv) $small_branch_position = 2;
                else $small_branch_position = 1;
                //end check small branch definition

                //start check next status conditions and move
                $pv = Hierarchy::pvCounter($item,$small_branch_position);
                $left_user = User::whereSponsorId($item)->wherePosition(1)->whereStatus(1)->first();
                $right_user = User::whereSponsorId($item)->wherePosition(2)->whereStatus(1)->first();

                $item_user_program = UserProgram::where('user_id',$item)->first();
                $item_status = Status::find($item_user_program->status_id);

                $next_status = Status::find($item_status->order+1);

                //copied from UserActivated
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
                                        $small_branch_user = User::where('sponsor_id',$item_user_program)->where('position',$small_branch_position)->first();

                                        $status_condition_count = UserProgram::where('list','like','%,'.$small_branch_user->id.','.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,2)
                                            ->count();

                                        if($status_condition_count == 0) $needed_upgrade = false;
                                    }
                                }

                                if($next_status->id == 4){
                                    if (!in_array($item_user_program->package_id, [1,2,3])) $needed_upgrade = false;
                                    else{
                                        $status_condition_count2 = UserProgram::where('list','like','%,'.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,2)
                                            ->count();

                                        $status_condition_count3 = UserProgram::where('list','like','%,'.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,3)
                                            ->count();

                                        if($status_condition_count2+$status_condition_count3 < 2) $needed_upgrade = false;

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
                                        $status_condition_count2 = UserProgram::where('list','like','%,'.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,4)
                                            ->count();

                                        $status_condition_count3 = UserProgram::where('list','like','%,'.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,5)
                                            ->count();

                                        if($status_condition_count2+$status_condition_count3 < 2) $needed_upgrade = false;
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
                                        $status_condition_count2 = UserProgram::where('list','like','%,'.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,6)
                                            ->count();

                                        $status_condition_count3 = UserProgram::where('list','like','%,'.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,7)
                                            ->count();

                                        if($status_condition_count2+$status_condition_count3 < 2) $needed_upgrade = false;
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

                                        if($status_condition_count <= 2) $needed_upgrade = false;
                                    }
                                }

                                if($next_status->id == 11){
                                    if (!in_array($item_user_program->package_id, [3])) $needed_upgrade = false;
                                    else{
                                        $status_condition_count2 = UserProgram::where('list','like','%,'.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,8)
                                            ->count();

                                        $status_condition_count3 = UserProgram::where('list','like','%,'.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,9)
                                            ->count();

                                        if($status_condition_count2+$status_condition_count3 < 2) $needed_upgrade = false;
                                    }
                                }

                                if($next_status->id == 12){
                                    if (!in_array($item_user_program->package_id, [3])) $needed_upgrade = false;
                                    else{
                                        $status_condition_count2 = UserProgram::where('list','like','%,'.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,9)
                                            ->count();

                                        $status_condition_count3 = UserProgram::where('list','like','%,'.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,10)
                                            ->count();

                                        if($status_condition_count2+$status_condition_count3 < 2) $needed_upgrade = false;
                                    }
                                }

                                if($next_status->id == 13){
                                    if (!in_array($item_user_program->package_id, [3])) $needed_upgrade = false;
                                    else{
                                        $status_condition_count = UserProgram::where('list','like','%,'.$item_user_program->user_id.',%')
                                            ->where('status_id', '>=' ,11)
                                            ->count();

                                        if($status_condition_count <= 2) $needed_upgrade = false;
                                    }
                                }


                                if($needed_upgrade){
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
                                }

                            }
                        }
                    }
                }
        }
        /*end set  invite_bonus  */

    }
}
