<?php namespace Elozoya\MediaFromWeb\Unit;

use PHPUnit_Framework_TestCase;
use Mockery as m;
use Elozoya\MediaFromWeb\MediaFromWeb;

class MediaFromWebTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testGetPhotosReturnsAnErrorResultDueToAnUnsuccessfulRequest()
    {
        $mockHttpClient = m::mock('\GuzzleHttp\Client');
        $mockResponse = m::mock('StdClass');
        $mediaFromWeb = new MediaFromWeb($mockHttpClient);
        $url = "http://foo.com/bar.png";
        $mockHttpClient->shouldReceive("request")->once()->with('HEAD', $url)->andReturn($mockResponse);
        $mockResponse->shouldReceive('isSuccessful')->once()->andReturn(false);
        $result = $mediaFromWeb->getPhotosFromUrl($url);
        $this->assertEquals($result, (object)[
          "error" => true,
          'message' => "Photos not found or you are not allowed to get them",
        ]);
    }
}
