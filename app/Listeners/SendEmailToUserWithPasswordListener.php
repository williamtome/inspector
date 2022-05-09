<?php

namespace App\Listeners;

use App\Mail\RegisteredUser;
use Illuminate\Support\Facades\Mail;

class SendEmailToUserWithPasswordListener
{
    public function handle($event)
    {
        Mail::to($event->user->email)
            ->send(new RegisteredUser($event->user, $event->password));

        info('Enviado o e-mail para o usuário ' . $event->user->name);
    }
}
