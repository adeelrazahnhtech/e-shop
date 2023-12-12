<?php

namespace App\Console\Commands;

use App\Mail\RegisterUserEmail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmailSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the email automatically';

    /**
     * Execute the console command.
     */
    public function handle()
    {
            $users = User::all();
        foreach ($users as $user)
       {
       Mail::to($user->email)->send(new RegisterUserEmail($user));
    }
    $this->info('Hourly Update has been send successfully');
}

}
