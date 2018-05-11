<?php

namespace Tests\E2E;

use App\Http\Request;

class SessionTest extends  TestCase
{
    public function testCreateSession()
    {
        $request = new Request(
            '/session',
            Request::METHOD_POST,
            ['Content-Type' => 'application/json'],
            [],
            '{"username" : "test" , "password" : "12345"}'
        );

        $response = $this->runPipeline($request);
        $payload = $response->getPayload();


        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals($_SESSION['_sid'], $payload['sid']);
    }
}