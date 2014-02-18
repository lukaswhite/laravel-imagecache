<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


class ImagecacheFlushCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'imagecache:flush';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Flush imagecache files.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$this->info('Flushing Imagecache files');

		$preset = $this->input->getArgument('name');

	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('preset', InputArgument::REQUIRED, 'The preset to flush, or ALL for all of them.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('foo', null, InputOption::VALUE_OPTIONAL, 'The preset to flush.', null),
		);
	}

}