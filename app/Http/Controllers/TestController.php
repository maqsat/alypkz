<?php

namespace App\Http\Controllers;


use App\Facades\Balance;
use App\Mail\ProcessingEmail;
use App\Models\Counter;
use App\Models\Order;
use App\Models\UserProgram;
use DB;
use App\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Notification;
use App\Models\Processing;
use App\Models\Status;
use App\Models\Package;
use App\Facades\Hierarchy;
use App\Events\Activation;
use App\Events\ShopTurnover;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{


    public function tester()
    {

        $position1_user = User::where('sponsor_id',1)->where('position',1)->first();

        if(!is_null($position1_user)){
            $status_condition_count2 = UserProgram::where('list','like','%,'.$position1_user->id.',1,%')
                ->where('status_id', '>=' ,3)
                ->take(1)
                ->get();

        }
        else {
            $status_condition_count2 = [];
            dd(count(0));
};
        $status_condition_count2 = [];
        dd(count($status_condition_count2));

    }

    public function afterHack()
    {
        $deleted_users  = [
            [
                'id'        => 770,
                'name'      => 'Сабалакова Венера Жолдаскалиева',
                'number'        => "+77752503882",
                'email'         => "venera1982@mail.ru",
                'inviter_id'    => 708,
                'sponsor_id'    => 710,
                'created_at'    => "2023-05-22 07:39:39",
                'package_id'    => 1,
                'gender'        => 1,
                'birthday'      => "04.04.20",
                'address'       => "address",
                'password'      => '$2y$10$VEeAZGJdX3ge9FEP3gDXn.6bxBlluFu49n2dTVfDSvKn35uBEoCxe',
                'country_id'    => 1,
                'city_id'       => 1,
                'position'      => 1,
                'program_id'    => 1,
            ],
            [
                'id'        => 771,
                'name'      => 'Сабалакова Венера 2',
                'number'        => "+77752503882",
                'email'         => "venera1982@bk.ru",
                'inviter_id'    => 770,
                'sponsor_id'    => 770,
                'created_at'    => "2023-05-21 07:39:39",
                'package_id'    => 2,
                'gender'        => 1,
                'birthday'      => "04.04.20",
                'address'       => "address",
                'password'      => '$2y$10$VEeAZGJdX3ge9FEP3gDXn.6bxBlluFu49n2dTVfDSvKn35uBEoCxe',
                'country_id'    => 1,
                'city_id'       => 1,
                'position'      => 1,
                'program_id'    => 1,
            ],
            [
                'id'        => 772,
                'name'      => 'Айтжанова Гульчатай Жулдугуловна',
                'number'        => "87774692482",
                'email'         => "gulchatai87@gmail.com",
                'inviter_id'    => 759,
                'sponsor_id'    => 759,
                'created_at'    => "2023-05-22 07:39:39",
                'package_id'    => 3,
                'gender'        => 1,
                'birthday'      => "04.04.20",
                'address'       => "address",
                'password'      => '$2y$10$VEeAZGJdX3ge9FEP3gDXn.6bxBlluFu49n2dTVfDSvKn35uBEoCxe',
                'country_id'    => 1,
                'city_id'       => 1,
                'position'      => 1,
                'program_id'    => 1,
            ],
            [
                'id'        => 773,
                'name'      => 'Айтжан Гулнур Тулепбергенкызы',
                'number'        => "87083281828",
                'email'         => "aitzhangulnur00@gmail.com",
                'inviter_id'    => 688,
                'sponsor_id'    => 756,
                'created_at'    => "2023-05-22 07:39:39",
                'package_id'    => 2,
                'gender'        => 1,
                'birthday'      => "04.04.20",
                'address'       => "address",
                'password'      => '$2y$10$VEeAZGJdX3ge9FEP3gDXn.6bxBlluFu49n2dTVfDSvKn35uBEoCxe',
                'country_id'    => 1,
                'city_id'       => 1,
                'position'      => 1,
                'program_id'    => 1,
            ],
            [
                'id'        => 774,
                'name'      => 'Нұржанұлы Дамир',
                'number'        => "87053975133",
                'email'         => "nurzhan11@mail.ru",
                'inviter_id'    => 691,
                'sponsor_id'    => 755,
                'created_at'    => "2023-05-23 07:39:39",
                'package_id'    => 2,
                'gender'        => 1,
                'birthday'      => "04.04.20",
                'address'       => "address",
                'password'      => '$2y$10$VEeAZGJdX3ge9FEP3gDXn.6bxBlluFu49n2dTVfDSvKn35uBEoCxe',
                'country_id'    => 1,
                'city_id'       => 1,
                'position'      => 1,
                'program_id'    => 1,
            ],
            [
                'id'        => 775,
                'name'      => 'Кушербаева Бактылы Магзумовна',
                'number'        => "87774269175",
                'email'         => "kuserbaevabaktyly@gmail.com",
                'inviter_id'    => 691,
                'sponsor_id'    => 774,
                'created_at'    => "2023-05-21 07:39:39",
                'package_id'    => 1,
                'gender'        => 1,
                'birthday'      => "04.04.20",
                'address'       => "address",
                'password'      => '$2y$10$VEeAZGJdX3ge9FEP3gDXn.6bxBlluFu49n2dTVfDSvKn35uBEoCxe',
                'country_id'    => 1,
                'city_id'       => 1,
                'position'      => 1,
                'program_id'    => 1,
            ]
        ];

        //dd($deleted_users);

        foreach ($deleted_users as $item){

            User::create([
                'id'            => $item['id'],
                'name'          => $item['name'],
                'number'        => $item['number'],
                'email'         => $item['email'],
                'inviter_id'    => $item['inviter_id'],
                'sponsor_id'    => $item['sponsor_id'],
                'created_at'    => $item['created_at'],
                'package_id'    => $item['package_id'],
                'gender'        => 1,
                'birthday'      => "04.04.20",
                'address'       => "address",
                'password'      => '$2y$10$VEeAZGJdX3ge9FEP3gDXn.6bxBlluFu49n2dTVfDSvKn35uBEoCxe',
                'country_id'    => 1,
                'city_id'       => 1,
                'position'      => 1,
                'program_id'    => 1,
            ]);
        }

        //Апгрейд пользователя Умиртаева Анель Абзаловна ( 7 )
        //Апгрейд пользователя Макутова Клара Казиевна ( 736 )
        //Апгрейд пользователя Айтуғанқызы Аида ( 691 )
        //Апгрейд пользователя Жунисова Айнагуль Бектибайқызы ( 12 )

    }

    public function setBots()
    {
        for ($i = 0; $i < 1000; $i++){

            $all_users = User::whereNull('is_office_lider')->get();

            foreach ($all_users as $item){

                $listeners_count = User::where('sponsor_id',$item->id)->count();

                if($listeners_count == 0){
                    User::create([
                        'name'          => "1 name ".$item->id,
                        'number'        => "870170889".$item->id,
                        'email'         => "1mail@com.kz".$item->id,
                        'gender'        => 1,
                        'birthday'      => "04.04.20",
                        'address'       => "address",
                        'password'      => '$2y$10$VEeAZGJdX3ge9FEP3gDXn.6bxBlluFu49n2dTVfDSvKn35uBEoCxe',
                        'created_at'    => "2020-02-01 07:39:39",
                        'country_id'    => 1,
                        'city_id'       => 1,
                        'inviter_id'    => $item->id,
                        'sponsor_id'    => $item->id,
                        'position'      => 1,
                        'package_id'    => 1,
                        'program_id'    => 1,
                    ]);


                    User::create([
                        'name'          => "2 name ".$item->id,
                        'number'        => "870170889".$item->id,
                        'email'         => "2mail@com.kz".$item->id,
                        'gender'        => 1,
                        'birthday'      => "04.04.20",
                        'address'       => "address",
                        'password'      => '$2y$10$VEeAZGJdX3ge9FEP3gDXn.6bxBlluFu49n2dTVfDSvKn35uBEoCxe',
                        'created_at'    => "2020-02-01 07:39:39",
                        'country_id'    => 1,
                        'city_id'       => 1,
                        'inviter_id'    => $item->id,
                        'sponsor_id'    => $item->id,
                        'position'      => 2,
                        'package_id'    => 1,
                        'program_id'    => 1,
                    ]);


                    if($item->id == 5000) dd($item->id);

                    $item->is_office_lider = 1;
                    $item->save();

                }

            }
        }


    }

    public function testerMail()
    {
        Mail::send('auth.passwords.email', array('key' => 'value'), function ($message)
        {
            $message->from('xxxxx@xxxx.com');
            $message->to('xxxxx@xxxx.com', 'John Smith')->subject('Welcome!');
        });

    }

    public function tester2()
    {
        $users = User::join('user_programs','users.id','=','user_programs.user_id')
            ->where('users.status',1)
            ->get();

        foreach ($users as $item){
            $package_title = 'Без пакета';

            if($item->package_id != 0)  $package_title = Package::find($item->package_id)->title;

            echo $item->name.','.$item->number.','.$package_title.','.$item->created_at."<br>";
        }
    }


    public function delete()
    {
        $id = $_GET['id'];
        UserProgram::where('user_id',$id)->delete();
        Processing::where('user_id',$id)->delete();
        Counter::where('user_id',$id)->delete();
        User::find($id)->delete();

    }

    public function testerActivation()
    {

        $users = User::where('id','!=',1)->where('status',0)->orderBy('id')->get();

        foreach ($users as $item){
            event(new Activation($user = $item));
        }

    }

    public function changeStatusesPercentage()
    {
        dd(0);
        $list = DB::select('SELECT * FROM `processing` WHERE `created_at` >= \'2019-11-01 00:00:00\' AND `status` != \'register\'');

        foreach ($list as $item){
            $inviter_status = Status::find($item->status_id);
            $package = Package::find($item->package_id);

            if($item->status == 'sponsor_bonus'){
                Processing::where('user_id',$item->user_id)
                    ->where('sum',$item->sum)
                    ->where('status',$item->status)
                    ->where('program_id',$item->program_id)
                    ->where('package_id',$item->package_id)
                    ->where('status_id',$item->status_id)
                    ->where('created_at',$item->created_at)
                    ->update(['sum' => $package->bv*$inviter_status->sponsor_bonus/100*1]);
            }
            if($item->status == 'partner_bonus'){
                Processing::where('user_id',$item->user_id)
                    ->where('sum',$item->sum)
                    ->where('status',$item->status)
                    ->where('program_id',$item->program_id)
                    ->where('package_id',$item->package_id)
                    ->where('status_id',$item->status_id)
                    ->where('created_at',$item->created_at)
                    ->update(['sum' => $package->bv*$inviter_status->partner_bonus/100*1]);
            }
        }
    }

    public function setQS()
    {
        Hierarchy::setQSforManager(3);
        Hierarchy::setQSforManager(4);
    }

}
