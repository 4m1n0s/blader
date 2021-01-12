<?php

namespace IAmine\Blader\Output;

use Codedungeon\PHPCliColors\Color;

class Display
{

	public static function success($line)
	{

		return Color::bold_green().'+ '.Color::white().$line.PHP_EOL;
	}

	public static function error($line)
	{

		return Color::bold_red().'- '.Color::white().$line.PHP_EOL;
	}

	public static function compiled($line)
	{

		return Color::bold_green().'✔ '.Color::white().$line.PHP_EOL;
	}

	public static function failure($line)
	{

		return Color::bold_red().'✖ '.Color::white().$line.PHP_EOL;
	}

	public static function bold($line)
	{

		return Color::bold_white().$line.Color::white();
	}

}
