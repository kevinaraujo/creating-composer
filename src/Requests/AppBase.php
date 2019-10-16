<?php


namespace KevinAraujo\Requests;


class AppBase
{
    protected $prodUrl;
    protected $devUrl;

    protected $apiClientKey;
    protected $publicKey;
    protected $privateKey;
    protected $signatureHeaders;

    public function __construct()
    {
        $this->prodUrl = "https://api-auth.sandbox.qitech.app";
        $this->devUrl = "https://api-auth.sandbox.qitech.app";

        $this->apiClientKey = '16c8a1ec-8d75-47a1-b138-46746713b8d8';

        $this->publicKey = '-----BEGIN PUBLIC KEY-----
MIGbMBAGByqGSM49AgEGBSuBBAAjA4GGAAQBzq596bGXUVo0eaK9Cd3gavqGoswi
ihr2RaDUgZleVqF3MWSX1hPCizY6qNvg88SKRHeLmj2iSRw+smOe+zC1mF0AgCSd
2t/z3suwZXLujNq8SpwrLeQUOa1eDhM9B2b+Cm4ziJS46idCPyFGvUZm0u6Gk05u
eRMS6xnNtISQNS++eQ8=
-----END PUBLIC KEY-----';

        $this->privateKey = '-----BEGIN EC PRIVATE KEY-----
MIHcAgEBBEIAyRa+hgmiOpzUN+/0vAMLZxeK7MWtJnBU+eFpp+ydOgRUbQRfg/Mv
tLiKPNOfG9h1Nf45nBG4TQvzSEgLn5zcpY2gBwYFK4EEACOhgYkDgYYABAHOrn3p
sZdRWjR5or0J3eBq+oaizCKKGvZFoNSBmV5WoXcxZJfWE8KLNjqo2+DzxIpEd4ua
PaJJHD6yY577MLWYXQCAJJ3a3/Pey7Blcu6M2rxKnCst5BQ5rV4OEz0HZv4KbjOI
lLjqJ0I/IUa9RmbS7oaTTm55ExLrGc20hJA1L755Dw==
-----END EC PRIVATE KEY-----';

        $this->signatureHeaders = [
            'alg' => 'ES512',
            'typ' => 'JWT'
        ];
    }
}