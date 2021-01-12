<?php

namespace IAmine\Blader\Commands;

use IAmine\Blader\Blader;
use IAmine\Blader\Engines\FileEngine;
use IAmine\Blader\Engines\BladeEngine;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BuildCommand extends Command
{
	protected static $defaultName = 'build';

	protected function configure()
	{

		$this->setDescription('Compile Blade to HTML.')
		     ->setHelp('This command compiles Blade to Static Html');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{

		$output->writeln([
			'Building Templates',
			'==========================',
		]);

		(new Blader())->build();

		$output->writeln([
			'==========================',
			'Done.',
		]);

		return Command::SUCCESS;
	}

}