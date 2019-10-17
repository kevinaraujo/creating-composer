<?php

namespace PHPUnit\Test\Unit;

use KevinAraujo\App;
use PHPUnit\Framework\TestCase;

class DebtRequestTest extends TestCase
{
    public function testRequestIsSuccess()
    {
        $app = new App('dev');
        $response = $app->sendDebtRequest('/account', []);

        $data = json_decode($response);

        $this->assertIsObject($data);
        $this->assertArrayHasKey('encoded_body', (array) $data);
    }
}