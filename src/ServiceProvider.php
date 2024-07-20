<?php

namespace g4t\FilamentAccessControl;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    const CONFIG_PATH = __DIR__ . '/config/g4t-filament-access-control.php';
    const RESOURCE_PATH = __DIR__ . '/Resources';
    const MIGRATIONS_PATH = __DIR__ . '/migrations';

    public function boot()
    {
        $this->publishes([
            self::CONFIG_PATH => config_path('g4t-filament-access-control.php'),
        ], 'config');

        $this->publishes([
            self::RESOURCE_PATH => base_path('app/Filament/Resources'),
        ], 'resources');

        $this->publishes([
            self::MIGRATIONS_PATH => base_path('database/migrations'),
        ], 'resources');

    }

    public function register()
    {
        $this->mergeConfigFrom(
            self::CONFIG_PATH,
            'filament-access-control'
        );

    }
}
