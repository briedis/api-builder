<?php namespace Briedis\ApiBuilder;

use Illuminate\Support\ServiceProvider;

class ApiBuilderLaravelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../../views/', 'api-builder');
    }
}
