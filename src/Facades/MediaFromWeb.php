<?php namespace Elozoya\MediaFromWeb\Facades;

use Illuminate\Support\Facades\Facade;

class MediaFromWeb extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Elozoya\MediaFromWeb\MediaFromWeb';
    }
}
