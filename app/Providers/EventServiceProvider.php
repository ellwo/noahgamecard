<?php

namespace App\Providers;

use App\Events\RassedActevityCreated;
use App\Listeners\RassedActevityCreatedListener;
use App\Models\AdminNotify;
use App\Models\Paymentinfo;
use App\Models\RassedActevity;
use App\Models\UserNotification;
use App\Observers\AdminNotifyObserver;
use App\Observers\PaymentinfoObserver;
use App\Observers\RassedActevityObserver;
use App\Observers\UserNotificationObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        ],
        RassedActevityCreated::class => [
            RassedActevityCreatedListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        UserNotification::observe(UserNotificationObserver::class);
        Paymentinfo::observe(PaymentinfoObserver::class);
        RassedActevity::observe(RassedActevityObserver::class);
        AdminNotify::observe(AdminNotifyObserver::class);
        //
    }
}
