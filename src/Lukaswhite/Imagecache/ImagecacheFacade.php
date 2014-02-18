<?php namespace Lukaswhite\Imagecache;

use Illuminate\Support\Facades\Facade;

/**
 * ImagecacheFacade
 *
 */ 
class imagecacheFacade extends Facade {
 
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'imagecache'; }
 
}