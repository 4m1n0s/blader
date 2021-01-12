<?php

namespace IAmine\Blader\View;

use Illuminate\View\Compilers\BladeCompiler as BaseBladeCompiler;

class BladeCompiler extends BaseBladeCompiler
{
	protected function compileComponentTags($value)
	{

		if ( ! $this->compilesComponentTags) {
			return $value;
		}

		return (new ComponentTagCompiler(
			$this->classComponentAliases, $this->classComponentNamespaces, $this
		))->compile($value);
	}

}