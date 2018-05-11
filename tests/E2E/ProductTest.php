<?php

namespace Tests\E2E;

use App\Http\Request;

class ProductTest extends TestCase
{
    public function testGetOneProduct()
    {
        $this->initSession();

        $request = new Request(
            '/products/20',
            Request::METHOD_GET,
            [],
            ['sid' => $_SESSION['_sid']]
        );

        $response = $this->runPipeline($request);
        $this->assertSuccessResponse($response);

        $payload = $response->getPayload();
        $this->assertEquals(20, $payload['id']);
        $this->assertNotEmpty($payload['name']);
        $this->assertNotEmpty($payload['price']);
    }

    public function testGetAllProducts()
    {
        $this->initSession();


        $request = new Request(
            '/products',
            Request::METHOD_GET,
            [],
            ['sid' => $_SESSION['_sid'], 'limit' => 5, 'offset' => 3]
        );

        $response = $this->runPipeline($request);
        $this->assertSuccessResponse($response);

        $payload = $response->getPayload();

        $this->assertCount(5, $payload['data']);
        $this->assertGreaterThan(0, $payload['total']);
        $this->assertEquals(3, $payload['offset']);
    }

    private function initSession()
    {
        $_SESSION['_sid'] = md5(random_bytes(32));
    }
}