<?php

namespace KevinAraujo;

use KevinAraujo\Requests\Request;
use KevinAraujo\Validators\Validator;

class App
{
    private $env;

    public function __construct(string $env)
    {
        $this->env = $env;
    }

    public function validate()
    {
        $validator = new Validator();
        $response = $validator->execute();

        return $response;
    }

    public function sendDebtRequest($route, $postfields)
    {
        $request = new Request($this->env);
        $response = $request->post($route, $postfields);

        return $response;
    }
}