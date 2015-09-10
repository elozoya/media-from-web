<?php

use Mockery as m;
use Elozoya\MediaFromWeb\MediaFromWeb;

class MediaFromWebTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

}

