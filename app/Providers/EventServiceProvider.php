<?php

namespace App\Providers;

use Acme\Events\PostWasUpdated;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Acme\Listeners\SendEmailForUpdatedPostListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        PostWasUpdated::class => [
            SendEmailForUpdatedPostListener::class
        ]
    ];

    // public function shouldDiscoverEvents()
    // {
    //     return true;
    // }

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
