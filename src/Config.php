<?php

namespace yanlongli\AppStoreServerApi;

use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class Config
{
    protected $endpoint;
    protected $issuerId;
    protected $bundleId;
    protected $privateKey;
    protected $privateKeyId;
    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * @param string|array $endpoint
     * @param ?string      $bundleId
     * @param ?string      $issuerId
     * @param ?string      $privateKey
     * @param ?string      $privateKeyId
     */
    public function __construct($endpoint, ?string $issuerId = null, ?string $privateKey = null, ?string $privateKeyId = null, ?string $bundleId = null, ?ClientInterface $httpClient = null)
    {
        if (is_array($endpoint)) {
            extract($endpoint);
        }
        $this->endpoint     = $endpoint;
        $this->bundleId     = $bundleId;
        $this->issuerId     = $issuerId;
        $this->privateKey   = $privateKey;
        $this->privateKeyId = $privateKeyId;
        $this->httpClient   = $httpClient;
    }

    /**
     * @param Client|ClientInterface|null $httpClient
     *
     * @return Config
     */
    public function setHttpClient($httpClient)
    {
        $this->httpClient = $httpClient;
        return $this;
    }

    /**
     * @param mixed $endpoint
     *
     * @return Config
     */
    public function setEndpoint($endpoint): Config
    {
        $this->endpoint = $endpoint;
        return $this;
    }

    /**
     * @param string $issuerId
     *
     * @return Config
     */
    public function setIssuerId(string $issuerId): Config
    {
        $this->issuerId = $issuerId;
        return $this;
    }

    /**
     * @return ?string
     */
    public function getIssuerId()
    {
        return $this->issuerId;
    }

    /**
     * @param string $bundleId
     *
     * @return Config
     */
    public function setBundleId(string $bundleId): Config
    {
        $this->bundleId = $bundleId;
        return $this;
    }

    /**
     * @return ?string
     */
    public function getBundleId()
    {
        return $this->bundleId;
    }

    /**
     * @param string $privateKey
     *
     * @return Config
     */
    public function setPrivateKey(string $privateKey): Config
    {
        $this->privateKey = $privateKey;
        return $this;
    }

    /**
     * @return ?string
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * @param string $privateKeyId
     *
     * @return Config
     */
    public function setPrivateKeyId(string $privateKeyId): Config
    {
        $this->privateKeyId = $privateKeyId;
        return $this;
    }

    /**
     * @return ?string
     */
    public function getPrivateKeyId()
    {
        return $this->privateKeyId;
    }

    /**
     * @return ?string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }


    public function getHttpClient(): Client
    {
        return $this->httpClient ?? $this->httpClient = new Client([
            'base_uri' => $this->getEndpoint(),
            'headers'  => [
                'Authorization' => "Bearer " . $this->jwt(),
            ]
        ]);
    }


    public function jwt(): string
    {
        $payload = [
            'iss'   => $this->getIssuerId(),
            "iat"   => time() - 10,
            "exp"   => time() + 3590,
            "aud"   => "appstoreconnect-v1",
            "nonce" => $this->uuid(),
            "bid"   => $this->getBundleId(),
        ];
        return JWT::encode($payload, $this->getPrivateKey(), 'ES256', $this->getPrivateKeyId());
    }


    protected function uuid(): string
    {
        $chars = md5(uniqid(mt_rand(), true));
        return substr($chars, 0, 8) . '-'
            . substr($chars, 8, 4) . '-'
            . substr($chars, 12, 4) . '-'
            . substr($chars, 16, 4) . '-'
            . substr($chars, 20, 12);
    }
}