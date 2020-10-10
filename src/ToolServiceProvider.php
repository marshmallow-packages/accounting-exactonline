<?php

namespace Marshmallow\ExactOnline;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Marshmallow\ExactOnline\Console\InstallCommand;
use Marshmallow\ExactOnline\Http\Middleware\Authorize;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'exact-online');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->mergeConfigFrom(
            __DIR__ . '/../config/exactonline.php',
            'exactonline'
        );
        
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../config/exactonline.php' => config_path('exactonline.php'),
        ], 'config');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'exact-online');

        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            Nova::script('exact-online-card', __DIR__.'/../dist/js/card.js');
            Nova::style('exact-online-card', __DIR__.'/../dist/css/card.css');
            Nova::script('exact-online-field', __DIR__.'/../dist/js/field.js');
            Nova::style('exact-online-field', __DIR__.'/../dist/css/field.css');
            Nova::script('exact-online-resource-tool', __DIR__.'/../dist/js/resource-tool.js');
            Nova::style('exact-online-resource-tool', __DIR__.'/../dist/css/resource-tool.css');
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
                ->prefix('nova-vendor/exact-online')
                ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
