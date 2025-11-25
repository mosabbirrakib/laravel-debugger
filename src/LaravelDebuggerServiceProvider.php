<?php

namespace AlmosabbirRakib\LaravelDebugger;

use AlmosabbirRakib\LaravelDebugger\Middleware\DebugbarMiddleware;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;

class LaravelDebuggerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/debugger.php',
            'debugger'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publish configuration
        $this->publishes([
            __DIR__ . '/../config/debugger.php' => config_path('debugger.php'),
        ], 'debugger-config');

        // Publish assets
        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/debugger'),
        ], 'debugger-assets');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'debugger');

        // Publish views
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/debugger'),
        ], 'debugger-views');

        // Register middleware
        if (config('debugger.enabled', false)) {
            $kernel = $this->app->make(Kernel::class);
            $kernel->pushMiddleware(DebugbarMiddleware::class);
        }
    }
}
