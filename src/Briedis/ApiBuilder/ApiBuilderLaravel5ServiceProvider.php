<?php namespace Briedis\ApiBuilder;

use Illuminate\Support\ServiceProvider;

class ApiBuilderLaravel5ServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function register()
    {
    }

    public function provides()
    {
        return [];
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../../views/', 'api-builder');
    }
}
