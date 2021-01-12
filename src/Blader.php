<?php

namespace IAmine\Blader;

use Illuminate\Support\Str;
use IAmine\Blader\Output\Console;
use IAmine\Blader\Engines\FileEngine;
use IAmine\Blader\Engines\BladeEngine;

class Blader
{
	private $bladeEngine;
	private $fileEngine;
	private $console;

	public function __construct()
	{

		$this->console     = new Console();
		$this->bladeEngine = new BladeEngine();
		$this->fileEngine  = new FileEngine();
	}

	public function build()
	{

		$this->fileEngine->removeCompiledDirectory();

		$files = $this->fileEngine->getBladeFiles();

		foreach ($files as $file) {

			$source = Str::of($file)
			             ->after($this->fileEngine->getSourcePath().'/')
			             ->rtrim('.blade.php');

			try {

				if ($this->fileEngine->saveCompiled($source, $this->bladeEngine->render($source))) {
					$this->console->success($source);
				}

			} catch (\Exception $e) {

				$this->console->error($source, $e->getMessage());
			}
		}

		$this->fileEngine->removeCacheDirectory();

		$this->fileEngine->copyAssetsDirectory();

		$this->console->result();

	}

}