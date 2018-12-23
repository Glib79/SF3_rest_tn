<?php // tests/Controller/CategoryControllerTest.php

namespace App\Tests\Controller;

use PHPUnit\Framework\TestCase;

class CategoryControllerTest extends TestCase
{
    private $http;

    public function setUp()
    {
        $this->http = new \GuzzleHttp\Client([
            'base_uri' => 'http://localhost',
            'defaults' => [
                'exceptions' => false
            ]
        ]);
    }

    public function tearDown() {
        $this->http = null;
    }    

    public function testGetCategories()
    {
        $response = $this->http->request('GET', '/api/categories');

        #Response without authentication
        $this->assertEquals(200, $response->getStatusCode());

        #What we rceived
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }
}
