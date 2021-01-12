<?php

namespace IAmine\Blader\Helpers;

use Exception;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use IAmine\Blader\Engines\FileEngine;

class Mix
{
	/**
	 * Get the path to a versioned Mix file.
	 *
	 * @param  string  $path
	 * @param  string  $manifestDirectory
	 *
	 * @return \Illuminate\Support\HtmlString|string
	 *
	 * @throws \Exception
	 */
	public function __invoke($path, $manifestDirectory = '')
	{

		static $manifests = [];

		if ( ! Str::startsWith($path, '/')) {
			$path = "/{$path}";
		}

		if ($manifestDirectory && ! Str::startsWith($manifestDirectory, '/')) {
			$manifestDirectory = "/{$manifestDirectory}";
		}

		$fileEngine = new FileEngine();

		if (is_file($fileEngine->getAssetPath($manifestDirectory.'/hot'))) {
			$url = rtrim(file_get_contents($fileEngine->getAssetPath($manifestDirectory.'/hot')));

			if (Str::startsWith($url, ['http://', 'https://'])) {
				return new HtmlString(Str::after($url, ':').$path);
			}

			return new HtmlString("//localhost:8080{$path}");
		}

		$manifestPath = $fileEngine->getAssetPath($manifestDirectory.'/mix-manifest.json');

		if ( ! isset($manifests[$manifestPath])) {
			if ( ! is_file($manifestPath)) {
				throw new Exception('The Mix manifest does not exist.');
			}

			$manifests[$manifestPath] = json_decode(file_get_contents($manifestPath), true);
		}

		$manifest = $manifests[$manifestPath];

		if ( ! isset($manifest[$path])) {
			throw new Exception("Unable to locate Mix file: {$path}.");
		}

		return new HtmlString('/'.$fileEngine->assetsDir.$manifestDirectory.$manifest[$path]);
	}

}
