<?php

namespace Tests\Unit\Http;

use App\Container;
use App\Http\Pipeline;
use App\Http\PipelineException;
use App\Http\Request;
use App\Http\Response;
use PHPUnit\Framework\TestCase;

class PipelineTest extends TestCase
{
    public function testBaseRun()
    {
        $request = $this->prophesize(Request::class);
        $request->setMeta('from-a', 'a')->shouldBeCalled();
        $request->setMeta('from-b', 'b')->shouldBeCalled();
        $request->setMeta('from-d', 'd')->shouldNotBeCalled();

        $container = $this->prophesize(Container::class);


        $a = function (Request $request, callable $next) {
            $request->setMeta('from-a', 'a');
            return $next($request);
        };

        $b = function (Request $request, callable $next) {
            $request->setMeta('from-b', 'b');

            /** @var Response $response */
            $response = $next($request);

            $response->setPayload(
                'B-'.$response->getPayload()
            );

            return $response;
        };

        $c = new class {
            public function __invoke(Request $request, callable $next): Response
            {
                return new Response('C-payload');
            }
        };

        $d = function (Request $request, callable $next) {
            $request->setMeta('from-d', 'd');
            return $next($request);
        };

        $pipeline = new Pipeline($container->reveal(), [$a, $b, $c, $d]);
        $response = $pipeline->run($request->reveal());

        $this->assertEquals('B-C-payload', $response->getPayload());
    }

    public function testNestedRun()
    {
        $request = $this->prophesize(Request::class);
        $request->setMeta('from-a', 'a')->shouldBeCalled();
        $request->setMeta('from-aa', 'aa')->shouldBeCalled();

        $container = $this->prophesize(Container::class);

        $a = function (Request $request, callable $next) {
            $request->setMeta('from-a', 'a');

            $aa = function (Request $request, callable $next) {
                $request->setMeta('from-aa', 'aa');
                return $next($request);
            };

            $ab = function (Request $request, callable $next) {
                return new Response('AB-payload');
            };

            return [$aa, $ab];
        };


        $pipeline = new Pipeline($container->reveal(), [$a]);
        $response = $pipeline->run($request->reveal());

        $this->assertEquals('AB-payload', $response->getPayload());
    }

    public function testInvalidPipe()
    {
        $this->expectException(PipelineException::class);

        $request = $this->prophesize(Request::class);
        $container = $this->prophesize(Container::class);

        $pipeline = new Pipeline($container->reveal(), [new \stdClass()]);
        $pipeline->run($request->reveal());
    }
}
