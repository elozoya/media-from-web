<?php namespace Elozoya\MediaFromWeb\Unit;

use PHPUnit_Framework_TestCase;
use Mockery as m;
use Elozoya\MediaFromWeb\MediaFromWeb;

class MediaFromWebTest extends PHPUnit_Framework_TestCase
{
    private $httpClientMock;
    private $reponseMock;
    private $mediaFromWeb;

    public function setUp()
    {
        $this->httpClientMock = m::mock('\GuzzleHttp\Client');
        $this->responseMock = m::mock('StdClass');
        $this->mediaFromWeb = new MediaFromWeb($this->httpClientMock);
    }

    public function tearDown()
    {
        m::close();
    }

    public function testGetPhotosReturnsAnErrorResultDueToAnUnsuccessfulRequest()
    {
        $url = "http://foo.com/bar-does-not-exist.png";
        $this->httpClientMock->shouldReceive("request")->once()->with('HEAD', $url)->andReturn($this->responseMock);
        $this->responseMock->shouldReceive('isSuccessful')->once()->andReturn(false);
        $result = $this->mediaFromWeb->getPhotosFromUrl($url);
        $this->assertEquals($result, (object)[
          "error" => true,
          'message' => "Photos not found or you are not allowed to get them",
        ]);
    }

    public function testGetPhotosReturnsAnErrorResultDueToAnUnsupportedRequest()
    {
        $url = "http://foo.com/bar.xml";
        $this->httpClientMock->shouldReceive("request")->once()->with('HEAD', $url)->andReturn($this->responseMock);
        $this->responseMock->shouldReceive('isSuccessful')->once()->andReturn(true);
        $this->responseMock->shouldReceive('getHeader')->once()->with('content-type')->andReturn("application/xml");
        $result = $this->mediaFromWeb->getPhotosFromUrl($url);
        $this->assertEquals($result, (object)[
          "error" => true,
          'message' => "Photos not found due to an unsupported request",
        ]);
    }
}
