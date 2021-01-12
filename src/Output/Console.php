<?php

namespace IAmine\Blader\Output;

use Illuminate\Support\Str;

class Console
{
	private $results;

	public function __construct()
	{

		$this->results = [
			'startTime' => microtime(true),
			'endTime'   => 0,
			'builds'    => 0,
			'errors'    => 0,
		];

	}

	public function success($file)
	{

		$this->results['builds']++;
		echo Display::success($this->getSuccessMessage($file));
	}

	public function error($file, $error)
	{

		$this->results['errors']++;
		echo Display::error($this->getErrorMessage($file, $error));
	}

	public function result()
	{

		$this->results['endTime'] = microtime(true);

		$buildTime = round((($this->results['endTime'] - $this->results['startTime']) * 1000), 2);

		if ($builds = $this->results['builds']) {
			echo Display::compiled($this->getCompiledMessage($builds, $buildTime));
		}

		if ($errors = $this->results['errors']) {
			echo Display::failure($this->getFailureMessage($errors));
		}

		return $this->results;
	}

	private function getFailureMessage($errors)
	{

		return Display::bold($errors.' '.Str::plural('Page', $errors)).' could not be built, see errors above';
	}

	private function getCompiledMessage($builds, float $buildTime)
	{

		return Display::bold($builds.' '.Str::plural('Page', $builds)).' built in '.Display::bold($buildTime.'ms');
	}

	private function getSuccessMessage($file)
	{

		return sprintf('%s.blade.php compiled to %s.html', $file, $file);
	}

	private function getErrorMessage($file, $error)
	{

		return sprintf('Unable to compile %s.blade.php'.PHP_EOL.'%s', $file, $error);
	}

}