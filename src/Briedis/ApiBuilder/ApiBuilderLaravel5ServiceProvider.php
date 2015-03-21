<?php namespace Briedis\ApiBuilder;

use Illuminate\Support\ServiceProvider;

class ApiBuilderLaravel5ServiceProvider extends ServiceProvider{
	protected $defer = false;

	public function register(){
	}

	public function provides(){
		return array();
	}

	public function boot(){
		$this->loadViewsFrom(__DIR__ . '/../../views/', 'api-builder');
		$this->publishes(array(
			__DIR__ . '/../../../public' => public_path('/packages/briedis/api-builder/'),
		));
	}
}
