<?php

namespace App\Providers;

use App\Events\RegUserEvent;
use App\Listeners\NewOrderListener;
use App\Listeners\RegUserListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
// use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            [NewOrderListener::class, 'handle2' ]
        ],
        // 'RegUserEvent' => [ RegUserListener::class ],
        // 'RegUserEvent' => [ RegUserListener::class, 'handle' ],        
        // 'Illuminate\Auth\Events\Login' => [ 'App\Listeners\UserEventListener' ]
        // 'Illuminate\Auth\Events\Registered' => [ RegUserListener::class ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        # Указываем собственный метод класса
        // app('events')->listen('RegUserEvent', [RegUserListener::class, 'handle' ]);
        app('events')->listen('NewOrderEvent', [NewOrderListener::class, 'handle' ]);

    }
}