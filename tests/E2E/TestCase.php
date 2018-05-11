<?php

namespace Tests\E2E;

use App\Container;
use App\Http\Pipeline;
use App\Http\Request;
use App\Http\Response;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

abstract class TestCase extends PHPUnitTestCase
{
    protected $container;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $services = require __DIR__.'/../../src/config/services.php';
        $this->container = new Container($services);
        parent::__construct($name, $data, $dataName);
    }

    public function runPipeline(Request $request): Response
    {
        $http = require __DIR__.'/../../src/config/http.php';

        $response = (new Pipeline($this->container, $http))->run($request);
        $response->setPayload(
            json_decode($response->getPayload(), true)
        );
        return $response;
    }

    public function assertSuccessResponse(Response $response)
    {
        $this->assertEquals(200, $response->getStatusCode());
    }
}