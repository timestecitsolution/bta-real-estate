<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
// Models
use App\Models\EmiPayment;
use App\Models\ClientNotice;
use App\Models\CentralApplication;
use App\Models\Contact;

// Observers — প্রতিটা আলাদা করে লিখুন
use App\Observers\EmiPaymentObserver;
use App\Observers\ClientNoticeObserver;
use App\Observers\CentralApplicationObserver;
use App\Observers\ContactObserver;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Fore HTTPs if enabled to fix any problems with mixed contents
        if (!empty(@$_SERVER['https']) || @$_SERVER['HTTPS'] == 'on' || (!empty(@$_SERVER['HTTP_X_FORWARDED_PROTO']) && @$_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) {
            URL::forceScheme('https');
        }

        Paginator::useBootstrap();
        Schema::defaultStringLength(191);

        EmiPayment::observe(EmiPaymentObserver::class);
        ClientNotice::observe(ClientNoticeObserver::class);
        CentralApplication::observe(CentralApplicationObserver::class);
        Contact::observe(ContactObserver::class);
    }
}
