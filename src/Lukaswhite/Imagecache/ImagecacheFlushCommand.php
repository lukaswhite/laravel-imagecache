<?php namespace Lukaswhite\Imagecache;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Filesystem\Filesystem;


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

	private $config;

	private $filesystem;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($config, Filesystem $filesystem)
	{
		$this->config = $config;
		$this->filesystem = $filesystem;

		parent::__construct();

	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{		
		$preset = $this->input->getArgument('preset');

		if ($preset == 'all') {
			
			$this->info('Flushing imagecache for all presets');

			$path = sprintf('%s/images', public_path());

			$this->filesystem->cleanDirectory($path);

		} else {			
			if (!in_array($preset, array_keys($this->config['images.presets']))) {
				$this->error(sprintf('Preset %s doesn\'t exist', $preset));
				exit();	
			}

			$path = sprintf('%s/images/%s', public_path(), $preset);

			$this->filesystem->deleteDirectory($path);

			$this->info(sprintf('Flushing imagecache for preset %s', $preset));
		}		

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