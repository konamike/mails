<?php

namespace App\Providers;

use App\Models\Contractor;
use App\Models\Filedispatch;
use App\Models\Letter;
use App\Observers\ContractorObserver;
use App\Observers\FiledispatchObserver;
use App\Observers\LetterObserver;
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
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Filedispatch::observe(FiledispatchObserver::class);
        Contractor::observe(ContractorObserver::class);
        Letter::observe(LetterObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
