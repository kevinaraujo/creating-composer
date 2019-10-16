<?php


namespace KevinAraujo\Requests;

class Request extends AppBase
{
    const PROD_ENV = 'prod';
    const DEV_ENV = 'dev';

    private $url;

    public function __construct(string $env)
    {
        parent::__construct();

        if ($env == self::DEV_ENV) {
            $this->url = $this->devUrl;
            return true;
        }

        $this->url = $this->prodUrl;
    }

    public function post(string $endPoint, array $postFields)
    {
        $header = $this->makeHeader(
            'GET',
            $endPoint,
            $postFields
        );

        $route = $this->makeRoute($endPoint);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $route);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $response = curl_exec($ch);

        curl_close();

        return $response;
    }

    private function makeHeader(
        string $httpMethod,
        string $endPoint,
        array $postFields
    )
    {
        $authenticationHeader = new AuthenticationHeader(
            $this->apiClientKey,
            $httpMethod,
            $endPoint,
            $postFields
        );
        $authorizationKey = $authenticationHeader->makeAuthentiationKey();

        $header = [
            'AUTHORIZATION' => $authorizationKey,
            'API-CLIENT-KEY' => $this->apiClientKey
        ];

        return $header;
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
}