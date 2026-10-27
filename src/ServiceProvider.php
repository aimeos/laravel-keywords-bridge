<?php

namespace Aimeos\KeywordsBridge;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;


class ServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/keywords-bridge.php', 'keywords-bridge');
        $this->app->singleton(Manager::class);
    }


    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/keywords-bridge.php' => config_path('keywords-bridge.php'),
        ], 'config');
    }
}
