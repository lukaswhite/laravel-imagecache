<?php namespace Lukaswhite\Imagecache;

use Illuminate\Filesystem\Filesystem;
use Config;

class Imagecache {

	protected $config;

	public function __construct($config) {
		$this->config = $config;
	}

	/**
	 * Get the URL to a derivative, given a preset and its base path.
	 *
	 * @param string $preset
	 * @param string $filepath
	 * @return string
	 */
	public function url($preset, $filepath) 
	{

		if (substr($filepath, 0, 1) == '/') {
			$filepath = substr($filepath, 1);
		}
		return sprintf('/images/%s/%s', $preset, $filepath);

	}

	/**
	 * Returns an <img> tag to a derivative, given a preset and its base path.
	 *
	 * @param string $preset
	 * @param string $filepath
	 * @param string $alt The image's alt tag
	 * @param string An optional array of HTML attributes
	 * @return string
	 */
	public function image($preset, $filepath, $alt, $attributes = array()) 
	{

		$url = self::url($preset, $filepath);


		return \HTML::image($url, $alt, $attributes);

	}

	/**
	 * Returns the HTML for a Picturefill image
	 *	 
	 * @param string $filepath
	 * @param string $alt The image's alt tag
	 * @param string An optional array of HTML attributes
	 * @return string
	 */
	public function picturefill($filepath, $alt, $attributes = array()) 
	{
		// Opening tag
		$html = sprintf("<span data-picture data-alt='%s'>\n", $alt);

		// The default (mobile-first) image
		$html .= sprintf("\t<span data-src='%s'></span>\n", self::url(Config::get('imagecache::picturefill.default'), $filepath));

		// Now loop through the additonal presets
		foreach (Config::get('imagecache::picturefill.presets') as $preset => $query) {
			$html .= sprintf("\t<span data-src='%s'     data-media='%s'></span>\n", self::url($preset, $filepath), $query);
		}

		// Non-JS fallback
		$html .= "\t<!-- Fallback content for non-JS browsers. Same img src as the initial, unqualified source element. -->\n";		
		$html .= sprintf("\t<noscript>\n\t\t<img src='%s' alt='%s'>\n\t</noscript>\n", self::url(Config::get('imagecache::picturefill.default'), $filepath), $alt);	
		$html .= "</span>";

		return $html;

	}

	/**
	 * Flush a preset - i.e., delete all the files for it.
	 *
	 * @param string $preset
	 */
	public function flushPreset($preset) {
		
		$path = sprintf('%s/images/%s', public_path(), $preset);

		$files = new Filesystem();
		$files->deleteDirectory($path);
	}

	/**
	 * Flush all presets - i.e., delete all the files for all of them.
	 *
	 * @param string $preset
	 */
	public function flushAll() {

		$path = sprintf('%s/images', public_path());

		$files = new Filesystem();
		$files->cleanDirectory($path);

	}

	/**
	 * Flush an image; i.e., delete all derivatives for a given image.
	 *
	 * @param string $path
	 */
	public function flushImage($path)
	{
		// Loop through the presets
		foreach (\Config::get('images.presets') as $preset => $preset_data) {

			// Determine the path
			$derivative = sprintf('%s/images/%s%s', public_path(), $preset, $path);			

			// If the fle exists, delete it
			if (file_exists($derivative)) {
				unlink($derivative);
			}
		}
	}

}