<?php namespace Elozoya\MediaFromWeb;

use Illuminate\Support\ServiceProvider;

class MediaFromWebServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Elozoya\MediaFromWeb\MediaFromWeb', function ($app) {
            return new \Elozoya\MediaFromWeb\MediaFromWeb(new \GuzzleHttp\Client);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['Elozoya\MediaFromWeb\MediaFromWeb'];
    }
}
