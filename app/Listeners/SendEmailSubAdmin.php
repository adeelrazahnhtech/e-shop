<?php

namespace App\Listeners;

use App\Events\RegisterSubAdmin;
use App\Mail\RegisterUserEmail;
use App\Models\SubAdmin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailSubAdmin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RegisterSubAdmin $event): void
    {
        $subAdminId = $event->subAdminId;
        $user = SubAdmin::find($subAdminId);
        Mail::to($user->email)->send(new RegisterUserEmail($user));
    }
}
