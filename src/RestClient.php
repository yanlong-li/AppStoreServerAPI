<?php

namespace yanlongli\AppStoreServerApi;

use Firebase\JWT\JWT;
use GuzzleHttp\ClientInterface;

class RestClient
{
    /**
     * @var ClientInterface
     */
    protected $httpClient;
    public $endpoint;
    protected $issuerId;
    protected $bundleId;
    protected $privateKey;
    protected $privateKeyId;

    public function __construct($endpoint, $bundleId, $issuerId, $privateKey, $privateKeyId)
    {
        $this->endpoint     = $endpoint;
        $this->bundleId     = $bundleId;
        $this->issuerId     = $issuerId;
        $this->privateKey   = $privateKey;
        $this->privateKeyId = $privateKeyId;
    }

    public function requestGet($path)
    {
        return $this->getClient()->get($this->endpoint . $path, [
            'headers' => [
                'Authorization' => "Bearer " . $this->jwt()
            ]
        ]);
    }

    public function requestGetContents($path)
    {
        return $this->requestGet($path)->getBody()->getContents();
    }

    public function requestPut($path, $body)
    {
        return $this->getClient()->put($this->endpoint . $path, [
            'headers' => [
                'Authorization' => "Bearer " . $this->jwt(),
                'Content-Type'  => 'application/json'
            ],
            'body'    => $body
        ]);
    }

    public function requestPutContents($path, $body)
    {
        return $this->requestPut($path, $body)->getBody()->getContents();
    }

    public function requestPost($path, $body)
    {
        return $this->getClient()->post($this->endpoint . $path, [
            'headers' => [
                'Authorization' => "Bearer " . $this->jwt(),
            ],
            'json'    => $body,
        ])->getBody()->getContents();
    }

    public function requestPostContents($path, $body)
    {
        return $this->requestPost($path, $body)->getBody()->getContents();
    }

    private function getClient()
    {
        return $this->httpClient ?? $this->httpClient = new \GuzzleHttp\Client();
    }


    protected function jwt()
    {
        $payload = [
            'iss'   => $this->issuerId,
            "iat"   => time() - 10,
            "exp"   => time() + 3590,
            "aud"   => "appstoreconnect-v1",
            "nonce" => $this->uuid(),
            "bid"   => $this->bundleId,
        ];
        return JWT::encode($payload, $this->privateKey, 'ES256', $this->privateKeyId);
    }

    protected function uuid()
    {
        $chars = md5(uniqid(mt_rand(), true));
        return substr($chars, 0, 8) . '-'
            . substr($chars, 8, 4) . '-'
            . substr($chars, 12, 4) . '-'
            . substr($chars, 16, 4) . '-'
            . substr($chars, 20, 12);
    }

    /**
     * @return ClientInterface
     */
    public function getHttpClient()
    {
        return $this->getClient();
    }

    /**
     * @param mixed $guzzleHttpClient
     */
    public function setHttpClient(ClientInterface $guzzleHttpClient)
    {
        $this->httpClient = $guzzleHttpClient;
    }
}