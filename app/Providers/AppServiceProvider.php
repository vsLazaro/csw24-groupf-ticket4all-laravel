<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\TicketRepository;
use App\Repositories\TicketRepositoryImpl;
use App\Repositories\ClientRepository;
use App\Repositories\ClientRepositoryImpl;
use App\Repositories\TenantRepository;
use App\Repositories\TenantRepositoryImpl;
use App\Repositories\EventRepository;
use App\Repositories\EventRepositoryImpl;
use App\Repositories\TransactionRepository;
use App\Repositories\TransactionRepositoryImpl;
use App\Repositories\NotificationPreferenceRepository;
use App\Repositories\NotificationPreferenceRepositoryImpl;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Bind interfaces to their implementations
        $this->app->bind(TicketRepository::class, TicketRepositoryImpl::class);
        $this->app->bind(ClientRepository::class, ClientRepositoryImpl::class);
        $this->app->bind(TenantRepository::class, TenantRepositoryImpl::class);
        $this->app->bind(EventRepository::class, EventRepositoryImpl::class);
        $this->app->bind(TransactionRepository::class, TransactionRepositoryImpl::class);
        $this->app->bind(NotificationPreferenceRepository::class, NotificationPreferenceRepositoryImpl::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
