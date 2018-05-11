<?php

namespace Tests\Unit\Service;

use App\Service\SessionService;
use PHPUnit\Framework\TestCase;

class SessionServiceTest extends TestCase
{
    public function testAuthenticate()
    {
        $username = 'test';
        $password = '1234';

        $service = new SessionService([
           'username' => $username,
           'password' => $password,
        ]);

        $sid = $service->authenticate($username, $password);
        $this->assertNotFalse($sid);

        $this->assertEquals($_SESSION['_sid'], $sid);

        $this->assertTrue($service->check($sid));
    }
}
