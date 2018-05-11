<?php

namespace Tests\Unit\Http;

use App\Http\Middleware\Route;
use App\Http\Request;
use App\Http\Response;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    public function testMatch()
    {
        $pipeline = [
            'pipeA',
            'pipeB',
        ];

        $request = $this->prophesize(Request::class);
        $request->isMethod(Request::METHOD_GET)->willReturn(true);
        $request->getUri()->willReturn('/tpattern/123');
        $request->setMeta('route', [123])->shouldBeCalled();

        $route = new Route('/tpattern/(\d+)', $pipeline, Request::METHOD_GET);


        $result = $route($request->reveal(), function () {});

        $this->assertEquals($pipeline, $result);
    }

    public function testNotMatch()
    {
        $request = $this->prophesize(Request::class);
        $request->isMethod(Request::METHOD_GET)->willReturn(false);

        $route = new Route('/tpattern/(\d+)', [], Request::METHOD_GET);
        $nextResponse = new Response('');
        $next = function (Request $request) use ($nextResponse) {
            return $nextResponse;
        };

        $result = $route($request->reveal(), $next);
        $this->assertEquals($nextResponse, $result);

        $request->isMethod(Request::METHOD_GET)->willReturn(true);
        $request->getUri()->willReturn('/not-pattern');

        $result = $route($request->reveal(), $next);
        $this->assertEquals($nextResponse, $result);
    }
}
