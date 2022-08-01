<?php

namespace Jasester\LaravelChinaAddress;

use Illuminate\Support\ServiceProvider;
use Jasester\LaravelChinaAddress\Commands\ImportAddress;

class ChinaAddressServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $timestamp = date('Y_m_d_His');

        $this->publishes([
            __DIR__.'/database/migrations/create_addresses_table.php' => $this->app->databasePath()."/migrations/{$timestamp}_create_addresses_table.php",
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                ImportAddress::class,
            ]);
        }
    }
}
