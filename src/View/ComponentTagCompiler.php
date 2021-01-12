<?php

namespace IAmine\Blader\View;

use Illuminate\Support\Str;
use Illuminate\View\ViewFinderInterface;
use Illuminate\View\Compilers\ComponentTagCompiler as BaseComponentTagCompiler;

class ComponentTagCompiler extends BaseComponentTagCompiler
{

	public function guessViewName($name)
	{

		$prefix = '_components.';

		$delimiter = ViewFinderInterface::HINT_PATH_DELIMITER;

		if (Str::contains($name, $delimiter)) {
			return Str::replaceFirst($delimiter, $delimiter.$prefix, $name);
		}

		return $prefix.$name;
	}

}