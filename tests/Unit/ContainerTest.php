<?php

namespace Tests\Unit;

use App\Container;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function testGetService()
    {
        $definition = [
            NoopService::class => function (Container $container) {
                return new NoopService();
            }
        ];

        $container = new Container($definition);

        $service = $container->get(NoopService::class);
        $this->assertInstanceOf(NoopService::class, $service);

        $sameServiceInstance = $container->get(NoopService::class);
        $this->assertEquals($service, $sameServiceInstance);
    }
}
