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

        $inviter_list_for_referral = explode(',',trim($user_program->inviter_list,','));
        $inviter_list_for_referral = array_slice($inviter_list_for_referral, 0, 2);




        foreach ($inviter_list_for_referral as $key_referral => $item_referral){
            if($key_referral == 0 && $item_referral != ""){
                Balance::changeBalance($item_referral,$event->order->amount*$package->invite_bonus/100,'invite_bonus',$id,$program->id,$package->id,'',$package->pv);

                //start check small branch definition
                $left_pv = Hierarchy::pvCounter($item_referral,1);
                $right_pv = Hierarchy::pvCounter($item_referral,2);
                if($left_pv > $right_pv) $small_branch_position = 2;
                else $small_branch_position = 1;
                //end check small branch definition

                //start check next status conditions and move
                $pv = Hierarchy::pvCounter($item_referral,$small_branch_position);

                $item_user_program = UserProgram::where('user_id',$item_referral)->first();
                $item_status = Status::find($item_user_program->status_id);

                $next_status = Status::find($item_status->order+1);


                if(!is_null($next_status)){
                    //$prev_statuses_pv = Status::where('order','<=',$next_status->order)->sum('pv');
                    $prev_statuses_pv = $next_status->pv;
                    if($prev_statuses_pv <= $pv){ // && count(Hierarchy::followersList($item)) <= $next_status->condition

                        if($item_user_program->is_binary == 1){
                            $needed_upgrade = true;

                            if($next_status->id == 5 && $item_user_program->package_id < 2){
                                $needed_upgrade = false;
                            }

                            if($next_status->id == 7 && $item_user_program->package_id < 3){
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
                                Hierarchy::moveNextStatus($item_referral,$next_status->id,$item_user_program->program_id);
                                $item_user_program = UserProgram::where('user_id',$item_referral)->first();
                                $item_status = Status::find($item_user_program->status_id);
                                Balance::changeBalance($item_referral,$item_status->status_bonus,'status_bonus',$id,$program->id,$item_user_program->package_id,$item_status->id);


                                Notification::create([
                                    'user_id'   => $item_referral,
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
