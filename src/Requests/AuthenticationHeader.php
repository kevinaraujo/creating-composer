<?php

namespace KevinAraujo\Requests;
use Jose\Component\Core\AlgorithmManager;
use Jose\Component\Core\JWK;
use Jose\Component\KeyManagement\KeyConverter\KeyConverter;
use Jose\Component\Signature\Algorithm\ES512;
use Jose\Component\Signature\Algorithm\HS256;
use Jose\Component\Signature\Algorithm\HS512;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\Serializer\CompactSerializer;

class AuthenticationHeader extends AppBase
{
    private $httpMethod;
    private $md5Content;
    private $contentType;
    private $endPoint;

    public function __construct(
        string $apiClientKey,
        string $httpMethod,
        string $endPoint,
        array $postFields
    )
    {
        parent::__construct();

        $this->apiClientKey = $apiClientKey;
        $this->httpMethod = $httpMethod;
        $this->md5Content = '';
        $this->contentType = '';
        $this->endPoint = $endPoint;

        if (sizeof($postFields) > 0){
            $this->md5Content = md5(json_encode($postFields));
            $this->contentType = 'application/json';
        }
    }

    public function makeAuthentiationKey()
    {

        $signedJWT = $this->mountSignedJWT();

        $result = sprintf(
            'QIT %s:%s',
            $this->apiClientKey,
            $signedJWT
        );

        return $result;
    }

    private function mountSignedJWT()
    {

        $algorithmManager = new AlgorithmManager([
            new ES512(),
        ]);

        $values = KeyConverter::loadFromKey($this->privateKey);

        $jwk = new JWK($values);
        $payload = $this->mountPayload();

        $jwsBuilder = new JWSBuilder($algorithmManager);
        $jws = $jwsBuilder->create()
            ->withPayload($payload)
            ->addSignature($jwk, ['alg' => 'ES512'])
            ->build();

        $serializer = new CompactSerializer();
        $signedJWT = $serializer->serialize($jws, 0);

        return $signedJWT;
    }

    private function mountPayload()
    {
        $httpVerb = $this->httpMethod;
        $md5Content = $this->md5Content;
        $contentType = $this->contentType;
        $date = gmdate('D, d M Y H:i:s T', time());
        $endPoint = $this->endPoint;

        $requestInformationSTR = sprintf(
            '%s\n%s\n%s\n%s\n%s',
            $httpVerb,
            $md5Content,
            $contentType,
            $date,
            $endPoint
        );

        $payload = json_encode([
            'sub' => $this->apiClientKey,
            'signature' => $requestInformationSTR
        ]);
        $payload = stripslashes($payload);

        return $payload;
    }

}