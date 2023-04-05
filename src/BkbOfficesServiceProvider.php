<?php

namespace Wovosoft\BkbOffices;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Wovosoft\BkbOffices\Actions\Offices;
use Wovosoft\BkbOffices\Actions\OfficeTypes;
use Wovosoft\BkbOffices\Commands\ExportOffices;
use Wovosoft\BkbOffices\Commands\ImportOffices;

class BkbOfficesServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'wovosoft');
//        if (config("bkb-offices.views_enabled")) {
//            $this->loadViewsFrom(__DIR__ . '/../resources/views', 'wovosoft');
//        }

//        Blade::componentNamespace("Wovosoft\\BkbOffices\\View\\Components", "bkb-offices");

        if (config("bkb-offices.migrations_enabled")) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        }

        if (config("bkb-offices.routes_enabled")) {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        }


        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/bkb-offices.php', 'bkb-offices');

        // Register the service the package provides.
        $this->app->singleton('bkb-offices', function ($app) {
            return new BkbOffices;
        });

        //will be used in main above singleton
        $this->app->singleton("bkb-offices:offices", function () {
            return new Offices();
        });

        //will be used in main above singleton
        $this->app->singleton("bkb-offices:office_types", function () {
            return new OfficeTypes();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return ['bkb-offices'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/bkb-offices.php' => config_path('bkb-offices.php'),
        ], 'bkb-offices.config');

        // Publishing the views.
        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/wovosoft'),
        ], 'bkb-offices.views');

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/wovosoft'),
        ], 'bkb-offices.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/wovosoft'),
        ], 'bkb-offices.views');*/

        // Registering package commands only when running in console.
        if ($this->app->runningInConsole()) {
            $this->commands([
                ImportOffices::class,
                ExportOffices::class
            ]);
        }
    }
}
