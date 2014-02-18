<?php namespace Lukaswhite\Imagecache;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;

class ImagecacheServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('lukaswhite/imagecache');

		include __DIR__ . '/../../routes.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['config']->package('lukaswhite/imagecache', __DIR__.'/../config');

		$this->app['imagecache'] = $this->app->share(function($app)
		{
			return new Imagecache($app['config']);
		});

		$this->app['imagecache.flush'] = $this->app->share(function($app)
		{			
			return new ImagecacheFlushCommand($app['config'], new Filesystem());
		});

		$this->registerCommands();
	}

	/**
	 * Make commands visible to Artisan
	 *
	 * @return void
	 */
	protected function registerCommands()
	{
		$this->commands(
			'imagecache.flush'
		);
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('imagecache');
	}

}