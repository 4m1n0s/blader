<?php

namespace IAmine\Blader\Engines;

use IAmine\Blader\View\Blade;

class BladeEngine
{

	private $blade;

	public function __construct()
	{

		$fileEngine = new FileEngine();

		$sourcePath = $fileEngine->getSourcePath();
		$cachePath  = $fileEngine->getCachePath();

		$fileEngine->ensureDirectoryExists($cachePath);

		$this->blade = new Blade($sourcePath, $cachePath);
	}

	public function render($source)
	{

		return $this->blade->render($source);
	}

}