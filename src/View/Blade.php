<?php

namespace IAmine\Blader\View;

use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Facade;
use Illuminate\Contracts\Foundation\Application;

class Blade implements ViewFactory
{

	private $container;
	private $factory;

	public function __construct($viewPath, $cachePath)
	{

		$this->container = new Container();

		$this->setupContainer((array) $viewPath, $cachePath);
		(new ViewServiceProvider($this->container))->register();

		$this->factory = $this->container->get('view');
	}

	private function setupContainer($viewPath, $cachePath)
	{

		$this->container->bindIf('files', function () {

			return new Filesystem();
		}, true);

		$this->container->bindIf('events', function () {

			return new Dispatcher();
		}, true);

		$this->container->singletonIf(ViewFactory::class, function () {

			return $this;
		});

		$this->container->bindIf('config', function () use ($viewPath, $cachePath) {

			return [
				'view.paths'    => $viewPath,
				'view.compiled' => $cachePath,
			];
		}, true);

		$this->container->singleton(Application::class, function () {

			return new class {
				public function getNamespace()
				{

					$composer = json_decode(file_get_contents('composer.json'), true);

					return count($composer['autoload']['psr-4'] ?? []) ? array_keys($composer['autoload']['psr-4'])[0] : null;
				}

			};
		});

		Container::setInstance($this->container);

		Facade::setFacadeApplication($this->container);
	}

	public function exists($view)
	{

		return $this->factory->exists($view);
	}

	public function file($path, $data = [], $mergeData = [])
	{

		return $this->factory->file($path, $data, $mergeData);
	}

	public function render($view, $data = [], $mergeData = [])
	{

		return $this->make($view, $data, $mergeData)->render();
	}

	public function make($view, $data = [], $mergeData = [])
	{

		return $this->factory->make($view, $data, $mergeData);
	}

	public function share($key, $value = null)
	{

		return $this->factory->share($key, $value);
	}

	public function composer($views, $callback)
	{

		return $this->factory->composer($views, $callback);
	}

	public function creator($views, $callback)
	{

		return $this->factory->creator($views, $callback);
	}

	public function addNamespace($namespace, $hints)
	{

		$this->factory->addNamespace($namespace, $hints);

		return $this;
	}

	public function replaceNamespace($namespace, $hints)
	{

		$this->factory->replaceNamespace($namespace, $hints);

		return $this;
	}

}