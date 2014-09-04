<?php namespace Lukaswhite\Imagecache;

use App,
		\Illuminate\Filesystem\Filesystem,
		Intervention\Image\Image,
		Intervention\Image\ImageManager,
		Config,
		Response;

class ImagecacheController extends \Controller {

	/**
	 * Imagecache handler for an image which hasn't yet been created - that's the job of this method.
	 */
	public function view($p1, $p2 = null, $p3 = null, $p4 = null, $p5 = null, $p6 = null, $p7 = null, $p8 = null)
	{

		//return $this->app['imagecache']->test();
		//return Imagecache::test();

		// Get the function's arguments
		$args = func_get_args();

		// Create a Filesystem instance
		$files = new Filesystem();

		// Start building the path
		$path = public_path() . '/images';

		// Go through parts, excluding he last one - which is the filename
		for ($i = 0; $i < (count($args)-1); $i++) {
			
			// Add the current level to the working path
			$path .= '/' . $args[$i];

			// If necessary, create the path
			if (!file_exists($path)) {
				$files->makeDirectory($path, 0777, true);
			}
		}

		// Now grab the preset
		$preset = array_shift($args);

		$filepath = implode('/', $args);
		
		// and the filename
		$filename = array_pop($args);

		if (!file_exists(storage_path() . '/' . $filepath)) {			
			App::abort(404);
		}

		$manager = new ImageManager(array('driver' => 'gd'));

		$image = $manager->make(storage_path() . '/' . $filepath);
			
		$config = Config::get('imagecache::presets.'.$preset);

		foreach ($config['actions'] as $action => $params) {

			switch ($action) {
				case 'scale_crop':
					$image->grab($params['width'], $params['height']);
					break;
				case 'crop':					
					$image->crop($params['width'], $params['height']);
					break;
				case 'resize':					
					$image->resize(
						((isset($params['width'])) ? $params['width'] : null),
						((isset($params['height'])) ? $params['height'] : null),
						function($constraint){
							if ((isset($params['ratio'])) && $params['ratio']) {
								$constraint->aspectRatio();    
							}
							if ((isset($params['upsize'])) && $params['upsize']) {
								$constraint->upsize();
							}
						}						
						);
					break;
				case 'flip':
					$image->flip(((isset($params['mode'])) ? $params['mode'] : 'vertical'));
					break;
			}
		}		
		
		$image->save($path . '/' . $filename);

		// Create the response
		// Note: the first param expects a string, so it'll use the __toString() method on Illuminate\Image
		$response = Response::make($image, 200, array(
			'Content-Type' => $image->mime(),
			//'Content-Length' => $info['file_size'],
		));

		// Return the response
		return $response;

	}

}