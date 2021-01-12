<?php

use IAmine\Blader\Helpers\Mix;

if ( ! function_exists('mix')) {
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
	function mix($path, $manifestDirectory = '')
	{

		return (new Mix())(...func_get_args());
	}
}