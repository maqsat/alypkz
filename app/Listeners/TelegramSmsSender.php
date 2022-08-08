<?php

namespace App\Listeners;

use App\Models\UserProgram;
use App\User;
use App\Models\Package;
use App\Events\Activation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TelegramSmsSender
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
     * @param  Activation  $event
     * @return void
     */
    public function handle(Activation $event)
    {
        $package = Package::find($event->user->package_id);
        $inviter = User::find($event->user->inviter_id);
        $sponsor = User::find($event->user->sponsor_id);
        $counter = UserProgram::count();

        $message = "АКТИВИРОВАН НОВЫЙ ПОЛЬЗОВАТЕЛЬ \n";
        $message .= "Пакет: $package->title ( $package->cost )\n";
        $message .= "Спонсор: ".$inviter->name." \n";
        $message .= "Наставник: ".$sponsor->name." \n";
        $message .= "Имя: ".$event->user->name." \n";
        $message .= "Почта: ".$event->user->email." \n";
        $message .= "Телефон: ".$event->user->number." \n";
        $message .= "Всего зарегистрировано: ".$counter." \n";
        $message = urlencode($message);

        $ch = curl_init("https://api.telegram.org/bot338084061:AAHlh9UWXyPVI7WnI4AALn2B6f0rafk-pmc/sendMessage?chat_id=-732950860&text=$message");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //---curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_exec($ch);
        curl_close($ch);
    }
}
