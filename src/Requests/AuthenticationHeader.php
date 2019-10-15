<?php

namespace KevinAraujo\Requests;

class AuthenticationHeader
{
    private $privateKey;
    private $accessKey;
    private $signatureHeader;

    private $httpMethod;
    private $MD5Content;
    private $endPoint;

    public function __construct(
        string $httpMethod,
        string $endPoint,
        array $postFields
    )
    {
        $this->privateKey = 'MIHcAgEBBEIAyRa+hgmiOpzUN+/0vAMLZxeK7MWtJnBU+eFpp+ydOgRUbQRfg/Mv
            tLiKPNOfG9h1Nf45nBG4TQvzSEgLn5zcpY2gBwYFK4EEACOhgYkDgYYABAHOrn3p
            sZdRWjR5or0J3eBq+oaizCKKGvZFoNSBmV5WoXcxZJfWE8KLNjqo2+DzxIpEd4ua
            PaJJHD6yY577MLWYXQCAJJ3a3/Pey7Blcu6M2rxKnCst5BQ5rV4OEz0HZv4KbjOI
            lLjqJ0I/IUa9RmbS7oaTTm55ExLrGc20hJA1L755Dw==';

        $this->accessKey = '16c8a1ec-8d75-47a1-b138-46746713b8d8';
        $this->signatureHeader = [
            'alg' => 'ES512',
            'typ' => 'JWT'
        ];

        $this->httpMethod = $httpMethod;
        $this->endPoint = $endPoint;
        $this->MD5Content = '';

        if (sizeof($postFields) > 0){
            $this->MD5Content = md5(json_encode($postFields));
        }
    }


    public function makeAuthentiationKey()
    {
        $signedJWT = $this->makeSignedJWT();

        $result = sprintf(
            'QIT %s:%s',
            json_encode($this->accessKey),
            json_encode($signedJWT)
        );

        return $result;
    }

    private function makeSignedJWT()
    {
        $requestInformationSTR = $this->makeRequestInformationSTR();

        $signatureJSON = [
            'sub' => $this->accessKey,
            'signature' => $requestInformationSTR
        ];
        echo die;
        $signedJWT = [
            $this->privateKey,
            base64_encode(json_encode($signatureJSON)),
            base64_encode(json_encode($this->signatureHeader))
        ];

        return $signedJWT;
    }

    private function makeRequestInformationSTR()
    {
        $HTTPVerb = $this->httpMethod;
        $MD5Content = $this->MD5Content;
        $ContentType = '';
        $Date = gmdate('D, d M Y H:i:s T', time());;
        $endPoint = $this->endPoint;


        $requestInformationSTR = sprintf(
    '%s\n%s\n%s\n%s\n%s',
            $HTTPVerb,
            $MD5Content,
            $ContentType,
            $Date,
            $endPoint
        );

        return $requestInformationSTR;
    }

}