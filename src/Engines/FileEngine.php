<?php

namespace IAmine\Blader\Engines;

use Symfony\Component\Finder\Finder;
use Illuminate\Filesystem\Filesystem;

class FileEngine
{

	private $sourceDir   = 'source';
	private $compiledDir = 'compiled';
	private $cacheDir    = 'cache';
	public  $assetsDir   = 'assets';

	private $basePath;
	private $fileSystem;

	public function __construct()
	{

		$this->basePath   = dirname(__FILE__, 3);
		$this->fileSystem = new Filesystem();
	}

	public function getSourcePath($path = null)
	{

		return $this->basePath.'/'.$this->sourceDir.($path ? '/'.ltrim($path, '/') : '');
	}

	public function getCompiledPath($path = null)
	{

		return $this->basePath.'/'.$this->compiledDir.($path ? '/'.ltrim($path, '/') : '');
	}

	public function getCachePath()
	{

		return $this->basePath.'/'.$this->cacheDir;
	}

	public function getAssetsPath($path = null)
	{

		return $this->getSourcePath($this->assetsDir.($path ? '/'.ltrim($path, '/') : ''));
	}

	public function getCompiledAssetsPath()
	{

		return $this->getCompiledPath($this->assetsDir);
	}

	public function getAssetPath($asset)
	{

		return $this->getAssetsPath('/'.ltrim($asset, '/'));
	}

	public function ensureDirectoryExists($path)
	{

		$this->fileSystem->ensureDirectoryExists($path);
	}

	public function removeCompiledDirectory()
	{

		$this->fileSystem->deleteDirectory($this->getCompiledPath());
	}

	public function removeCacheDirectory()
	{

		$this->fileSystem->deleteDirectory($this->getCachePath());
	}

	public function getBladeFiles()
	{

		return Finder::create()->files()
		             ->in($this->getSourcePath())
		             ->name(['*.blade.php'])
		             ->notPath('#(^|/)_.+(/|$)#')
		             ->ignoreDotFiles(true);
	}

	public function saveCompiled($source, $compiled)
	{

		$output = $this->getOutputFile($source);

		return boolval($this->fileSystem->put($output, $compiled));
	}

	private function getOutputFile($source)
	{

		$outputDir = collect(explode('/', $source));
		$outputDir->pop();
		$outputDir = rtrim($this->getCompiledPath().'/'.$outputDir->implode('/'), ' .\\/');

		$this->ensureDirectoryExists($outputDir);

		return $this->getCompiledPath().'/'.$source.'.html';
	}

	public function copyAssetsDirectory()
	{

		$this->fileSystem->copyDirectory($this->getAssetsPath(), $this->getCompiledAssetsPath());
	}

}