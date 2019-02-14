<?php // tests/Controller/ProductControllerTest.php

namespace App\Tests\Controller;

use PHPUnit\Framework\TestCase;

class ProductControllerTest extends TestCase
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

    public function testPostProductNoAuth()
    {
        $data = array(
            "name" => "Fony UHD HDR 55\" 4k TV",
            "category" => "TVs and Accessories",
            "sku" => "A0004",
            "price" => 1399.99,
            "quantity" => 5
        );
        $response = $this->http->request('POST', '/api/product', [
            'http_errors' => false,
            'body' => json_encode($data)
        ]);

        #Response without authentication
        $this->assertEquals(401, $response->getStatusCode());

        #What we rceived
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        #Check for received data
        $error = json_decode($response->getBody())->{"error"};
        $this->assertRegexp('/access_denied/', $error);
    }

    public function testGetProduct()
    {
        $response = $this->http->request('GET', '/api/products/1', ['http_errors' => false]);

        #Response without authentication
        $this->assertEquals(200, $response->getStatusCode());

        #What we rceived
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        #Check for received data
        $id = json_decode($response->getBody());
        $this->assertRegexp('/"id":1/', $id);
    }

    public function testGetProducts()
    {
        $response = $this->http->request('GET', '/api/products');

        #Response without authentication
        $this->assertEquals(200, $response->getStatusCode());

        #What we rceived
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
    }

    public function testPutProductNoAuth()
    {
        $data = array(
            "name" => "Fony UHD HDR 55\" 4k TV",
            "category" => "TVs and Accessories",
            "sku" => "A0004",
            "price" => 1399.99,
            "quantity" => 5
        );
        $response = $this->http->request('PUT', '/api/products/1', [
            'http_errors' => false,
            'body' => json_encode($data)
        ]);

        #Response without authentication
        $this->assertEquals(401, $response->getStatusCode());

        #What we rceived
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        #Check for received data
        $error = json_decode($response->getBody())->{"error"};
        $this->assertRegexp('/access_denied/', $error);
    }

    public function testDeleteProductNoAuth()
    {
        $response = $this->http->request('DELETE', '/api/products/1', [
            'http_errors' => false
        ]);

        #Response without authentication
        $this->assertEquals(401, $response->getStatusCode());

        #What we rceived
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        #Check for received data
        $error = json_decode($response->getBody())->{"error"};
        $this->assertRegexp('/access_denied/', $error);
    }
}
