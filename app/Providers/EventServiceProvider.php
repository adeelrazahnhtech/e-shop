<?php

namespace App\Providers;

use App\Events\LoginAdmin;
use App\Events\RegisterSubAdmin;
use App\Listeners\SendEmaiAdmin;
use App\Listeners\SendEmailSubAdmin;
use App\Models\Admin;
use App\Observers\AdminObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        RegisterSubAdmin::class => [
             SendEmailSubAdmin::class,
        ],
        LoginAdmin::class => [
            SendEmaiAdmin::class,
       ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {

    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
