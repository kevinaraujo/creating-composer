<?php

namespace PHPUnit\Test\Unit;

use KevinAraujo\App;
use PHPUnit\Framework\TestCase;

class DebtRequestTest extends TestCase
{
    public function testRequestSuccess()
    {
        $app = new App('dev');
        $data = $app->sendDebtRequest('/test', []);

        $this->assertEquals(
            'ok',
            $data
        );
    }
}