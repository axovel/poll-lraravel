<?php

namespace App\Listeners;

use App\Events\OnRegisterEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;

class OnRegisterListener
{
    /**
     * Handle the event.
     *
     * @param  OnRegisterEvent  $event
     * @return void
     */
    public function handle(OnRegisterEvent $event)
    {
        $user = $event->user;

        Mail::send('auth.emails.confirmation', ['user' => $user], function($message) use ($user) {
            $message->from(env('ACCOUNT_EMAIL'), env('SITE_NAME'));
            $message->to($user->email, $user->first_name)->subject(trans('messages.Activate your account!'));
        });
    }
}
