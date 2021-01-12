<?php

namespace IAmine\Blader\View;

use Illuminate\View\DynamicComponent;
use Illuminate\View\ViewServiceProvider as BaseViewServiceProvider;

class ViewServiceProvider extends BaseViewServiceProvider
{
	public function registerBladeCompiler()
	{

		$this->app->singleton('blade.compiler', function ($app) {

			return tap(new BladeCompiler($app['files'], $app['config']['view.compiled']), function ($blade) {

				$blade->component('dynamic-component', DynamicComponent::class);
			});
		});
	}

}