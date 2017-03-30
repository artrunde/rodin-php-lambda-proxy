<?php

use GuzzleHttp\Client;

class DebugTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Client
     */
    private $http;

    public function setUp()
    {
        // TODO get this from ENV
        $this->http = new GuzzleHttp\Client( ['base_uri' => getenv('ACTIVE_V1_URL')] );
    }

    public function tearDown()
    {
        $this->http = null;
    }

    public function test_should_return200_when_called()
    {
        $response = $this->http->request('GET', 'public/debug/');
        $this->assertEquals(200, $response->getStatusCode());
    }

}