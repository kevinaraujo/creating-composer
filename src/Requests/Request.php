<?php


namespace KevinAraujo\Requests;

class Request
{
    const PROD_ENV = 'prod';
    const DEV_ENV = 'dev';

    private $url;


    public function __construct(string $env)
    {
        if ($env == self::DEV_ENV) {
            $this->url = "https://api-auth.sandbox.qitech.app";
            return true;
        }

        $this->url = "https://api-auth.sandbox.qitech.app";
    }

    private function makeRoute($endPoint)
    {
        $route = sprintf(
            '%s/%s',
            $this->url,
            $endPoint
        );

        return $route;
    }

    private function makeHeader(
        string $httpMethod,
        string $endPoint,
        array $postFields
    )
    {
        $authenticationHeader = new AuthenticationHeader(
            $httpMethod,
            $endPoint,
            $postFields
        );
        $authorizationKey = $authenticationHeader->makeAuthentiationKey();

        $header = [
            'Authorization' => $authorizationKey
        ];

        return $header;
    }

    public function post(string $endPoint, array $postFields)
    {
        $header = $this->makeHeader(
                'post',
                $endPoint,
                $postFields
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->makeRoute($endPoint));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $response = 'ok'; //curl_exec($ch);

        curl_close();

        return $response;
    }
}