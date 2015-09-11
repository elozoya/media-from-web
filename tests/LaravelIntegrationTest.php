<?php namespace Elozoya\MediaFromWeb\Unit;

use PHPUnit_Framework_TestCase;
use Mockery as m;
use Elozoya\MediaFromWeb\MediaFromWebServiceProvider;
use Elozoya\MediaFromWeb\Facades\MediaFromWeb as MediaFromWebFacade;

/*
 * Test Laravel 5 Integration
 * ==========================
 */
class LaravelIntegrationTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
    }

    public function tearDown()
    {
        m::close();
    }

    public function testServiceProvider()
    {
        $appMock = m::mock('StdClass');
        $mediaFromWebServiceProvider = new MediaFromWebServiceProvider($appMock);
        $this->assertInstanceOf("Illuminate\Support\ServiceProvider", $mediaFromWebServiceProvider);
    }

    public function testFacade()
    {
        $mediaFromWebFacade = new MediaFromWebFacade();
        $this->assertInstanceOf("Illuminate\Support\Facades\Facade", $mediaFromWebFacade);
    }
}
