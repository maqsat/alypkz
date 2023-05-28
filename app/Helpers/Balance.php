<?php

namespace App\Helpers;

use App\Models\Counter;
use App\Models\Log;
use App\Models\UserProgram;
use App\User;
use App\Models\UserSubscriber;
use App\Models\Status;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Facades\Hierarchy;
use App\Models\Processing;

class Balance {

    public function changeBalance($user_id,$sum,$status,$in_user,$program_id,$package_id=0,$status_id=0,$pv = 0,$limited_sum = 0,$matching_line = 0,$card_number = 0,$message = '', $withdrawal_method = null, $type = null , $iin = null , $date = null )
    {

        if($date === null)
            $date = Carbon::now()->format('Y-m-d H:i:s');

        $processing = new Processing(
            [
                'user_id' => $user_id,
                'sum' => $sum,
                'status' => $status,
                'in_user' => $in_user,
                'program_id' => $program_id,
                'package_id' => $package_id,
                'status_id' => $status_id,
                'pv' => $pv,
                'card_number' => $card_number,
                'matching_line' => $matching_line,
                'limited_sum' => $limited_sum,
                'message' => $message,
                'withdrawal_method' => $withdrawal_method,
                'type' => $type,
                'iin' => $iin,
                'created_at' => $date,
            ]
        );
        $processing->save();
        return $processing->id;
    }

    public function setQV($user_id,$sum,$in_user,$package_id,$position,$status_id, $alias = null, $is_binary = null)
    {
        if(is_null($is_binary)) $is_binary = 0;

        Counter::insert(
            [
                'user_id' => $user_id,
                'sum' => $sum,
                'inner_user_id' => $in_user,
                'package_id' => $package_id,
                'position' => $position,
                'status_id' => $status_id,
                'alias' => $alias,
                'is_binary' => $is_binary,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                //'created_at' => '2019-07-13 07:55:45',
            ]
        );
    }


    public function getBalanceNew($user_id, $statuses)
    {
        $sum = $this->getIncomeBalanceByStatus($user_id, $statuses) - $this->getBalanceOutNew($user_id, $statuses) - $this->getWeekBalanceByStatusNew($user_id, $statuses);
        return round($sum, 2);
    }

    public function getIncomeBalanceByStatus($user_id, $statuses)
    {
        $sum =  Processing::whereUserId($user_id)
            ->whereIn('status', $statuses)
            ->sum('sum');
        return round($sum, 2);
    }


    public function getWeekBalanceByStatusNew($user_id, $statuses)
    {
        foreach($statuses as $key => $item){
            if ($item == "invite_bonus"){
                unset($statuses[$key]);
            }

            if ($item == "admin_add"){
                unset($statuses[$key]);
            }
        }

        $sum = Processing::whereUserId($user_id)->whereIn('status', $statuses)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('sum');
        return round($sum, 2);
    }


    public function getBalanceOutNew($user_id, $statuses)
    {

        if(array_search('invite_bonus', $statuses) !== false) $type = 1;
        else $type = 2;

        $sum = Processing::whereUserId($user_id)->whereIn('status', ['out', 'remove'])->where('type', $type)->sum('sum');
        return round($sum, 2);
    }

    public function getBalanceOutAllUserNew($statuses, $date_from = null, $date_to = null)
    {

        if(array_search('invite_bonus', $statuses) !== false) $type = 1;
        else $type = 2;

        if($date_from !== null)
        {
            $sum = Processing::whereIn('status', ['out', 'remove'])->where('type', $type)->whereBetween('created_at', [Carbon::parse($date_from), Carbon::parse($date_to)])->sum('sum');
        }
        else {
            $sum = Processing::whereIn('status', ['out', 'remove'])->where('type', $type)->sum('sum');
        }


        return round($sum, 2);
    }



    public function getBalanceOutAllUsers($date_from = null, $date_to = null)
    {
        if($date_from !== null)
        {
            $sum = Processing::whereIn('status', ['out', 'remove'])->whereBetween('created_at', [Carbon::parse($date_from), Carbon::parse($date_to)])->sum('sum');
        }
        else {
            $sum = Processing::whereIn('status', ['out', 'remove'])->sum('sum');
        }

        return round($sum, 2);
    }



    public function getWeekBalanceByRange($user_id,$date_from,$date_to)
    {
        $date_from = explode('-',$date_from);
        $date_from = Carbon::create($date_from[0], $date_from[1], $date_from[2],0,0,0, date_default_timezone_get())->toDateTimeString();

        $date_to = explode('-',$date_to);
        $date_to = Carbon::create($date_to[0], $date_to[1], $date_to[2],23,59,59, date_default_timezone_get())->toDateTimeString();
        $sum = Processing::whereUserId($user_id)->whereIn('status', ['invite_bonus', 'admin_add','turnover_bonus','matching_bonus'])->whereBetween('created_at', [$date_from, $date_to])->sum('sum');
        return round($sum, 2);
    }

    public function getWeekBalanceByStatus($user_id,$date_from,$date_to,$status)
    {
        $date_from = explode('-',$date_from);
        $date_from = Carbon::create($date_from[0], $date_from[1], $date_from[2],0,0,0, date_default_timezone_get())->toDateTimeString();

        $date_to = explode('-',$date_to);
        $date_to = Carbon::create($date_to[0], $date_to[1], $date_to[2],23,59,59, date_default_timezone_get())->toDateTimeString();

        $sum = Processing::whereUserId($user_id)->where('status', $status)->whereBetween('created_at', [$date_from, $date_to])->sum('sum');
        return round($sum, 2);
    }


    public function getBalanceAllUsers()
    {
        $sum = Processing::whereIn('status', ['invite_bonus', 'admin_add', 'turnover_bonus','matching_bonus','status_bonus'])->sum('sum') - Processing::whereIn('status', ['out','shop', 'remove'])->sum('sum');
        return round($sum, 2);
    }


    public function getBalance($user_id)
    {
        $sum = $this->getIncomeBalance($user_id) - $this->getBalanceOut($user_id) - $this->getWeekBalance($user_id);
        return round($sum, 2);
    }

    public function getWeekBalance($user_id)
    {
        $sum = Processing::whereUserId($user_id)->whereIn('status', ['admin_add', 'turnover_bonus', 'status_bonus', 'invite_bonus','quickstart_bonus','matching_bonus'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('sum');
        return round($sum, 2);
    }

    public function getIncomeBalance($user_id)
    {
        $sum =  Processing::whereUserId($user_id)->whereIn('status', ['admin_add', 'turnover_bonus', 'status_bonus', 'invite_bonus','quickstart_bonus','matching_bonus'])->sum('sum');
        return round($sum, 2);
    }

    public function getBalanceOut($user_id)
    {
        $sum = Processing::whereUserId($user_id)->whereIn('status', ['out','shop', 'remove'])->sum('sum');
        return round($sum, 2);
    }


    public function getBalanceByStatus($status)
    {
        $sum = Processing::where('status', $status)->sum('sum');
        return round($sum, 2);
    }


    public function getCashbackBalance($user_id)
    {
        $sum = Processing::whereUserId($user_id)->whereIn('status', ['cashback'])->sum('sum') - Processing::whereUserId($user_id)->whereIn('status', ['cashback_out'])->sum('sum');
        return round($sum, 2);
    }



    /*************************** OLD METHODS ****************************/



    public function getBalanceWithOut($user_id)
    {
        $sum = Processing::whereUserId($user_id)->whereStatus('in')->sum('sum') + Processing::whereUserId($user_id)->whereStatus('bonus')->sum('sum') + Processing::whereUserId($user_id)->whereStatus('percentage')->sum('sum')  + Processing::where('in_user',$user_id)->whereStatus('transfered_in')->sum('sum') - Processing::whereUserId($user_id)->whereStatus('out')->sum('sum')  - Processing::whereUserId($user_id)->whereStatus('transfered')->sum('sum')  - Processing::whereUserId($user_id)->whereStatus('request')->sum('sum') - Processing::whereUserId($user_id)->whereStatus('transfer')->sum('sum');
        return round($sum, 2);
    }

    public function getMondaysInRange($dateFromString, $dateToString)
    {
        $dateFrom = new \DateTime($dateFromString);
        $dateTo = new \DateTime($dateToString);
        $dates = [];

        if ($dateFrom > $dateTo) {
            return $dates;
        }

        if (1 != $dateFrom->format('N')) {
            $dateFrom->modify('this week monday ');
        }

        while ($dateFrom <= $dateTo) {
            $dates[] = $dateFrom->format('Y-m-d');
            $dateFrom->modify('+1 week');
        }

        return $dates;
    }

    public function getMonthByRange($start, $end)
    {
        $months = [];

        $period = CarbonPeriod::create($start, '1 month', $end);

        foreach ($period as $dt) {
            $months[] = $dt->format("Y-m");
        }

        return $months;

    }
}
