<?php

namespace App\Listeners;

use App\Events\LoginAdmin;
use App\Mail\RegisterUserEmail;
use App\Models\Admin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmaiAdmin
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
    public function handle(LoginAdmin $event): void
    {
        $adminId = $event->userId;
        $admin = Admin::find($adminId);
        Mail::to($admin->email)->send(new RegisterUserEmail($admin));
    }
}
