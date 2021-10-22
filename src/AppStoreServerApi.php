<?php

namespace yanlongli\AppStoreServerApi;

use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use yanlongli\AppStoreServerApi\request\ConsumptionRequest;
use yanlongli\AppStoreServerApi\request\ExtendRenewalDateRequest;

class AppStoreServerApi
{
    public $endpoint;
    protected $privateKeyId;
    protected $privateKey;
    protected $issuerId;
    public $bundleId;

    protected $guzzleHttpClient;

    /**
     * @param string $endpoint     Web Service Endpoint
     * @param string $privateKeyId private key id
     * @param string $privateKey   private key
     * @param string $issuerId     IssuerID
     * @link https://developer.apple.com/documentation/appstoreserverapi/creating_api_keys_to_use_with_the_app_store_server_api private and issuerid see
     */
    public function __construct($endpoint, $privateKeyId, $privateKey, $issuerId, $bundleId = null)
    {
        $this->endpoint = $endpoint;
        $this->privateKeyId = $privateKeyId;
        $this->privateKey = $privateKey;
        $this->issuerId = $issuerId;
        $this->bundleId = $bundleId;
    }

    public function jwt($bundleId = null)
    {
        $payload = [
            'iss' => $this->issuerId,
            "iat" => time() - 10,
            "exp" => time() + 3590,
            "aud" => "appstoreconnect-v1",
            "nonce" => $this->uuid(),
            "bid" => $bundleId ?: $this->bundleId,
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

    protected function getClient()
    {
        return $this->guzzleHttpClient ?: $this->guzzleHttpClient = new Client();
    }

    /**
     * @return array ["status"=>0,"signedTransactions"=>[JWS]]
     * @throws GuzzleException Response Codes
     * 200
     * OrderLookupResponse
     * OK
     * Request succeeded.
     *
     * Content-Type: application/json
     * 400
     * GeneralBadRequestError
     * Bad Request
     * The request is invalid and can’t be accepted.
     *
     * Content-Type: application/json
     * 401
     * Unauthorized
     * The request is unauthorized; the JSON Web Token (JWT) is invalid.
     *
     * 500
     * (GeneralInternalError | GeneralInternalRetryableError)
     * Internal Server Error
     * The request failed. This may be due to a temporary outage. Check the specific error message for further information.
     *
     * Content-Type: application/json
     * @link https://developer.apple.com/documentation/appstoreserverapi/orderlookupresponse OrderLookupResponse
     * @link https://developer.apple.com/documentation/appstoreserverapi/look_up_order_id Look Up Order ID
     */
    public function lookup($orderId, $bundleId = null)
    {
        $path = $this->endpoint . '/inApps/v1/lookup/' . $orderId;

        return json_decode($this->getClient()->get($path, [
            'headers' => [
                'Authorization' => "Bearer " . $this->jwt($bundleId)
            ]
        ])->getBody()->getContents(), true);

    }

    public function history($originalTransactionId, $revision = '', $bundleId = null)
    {
        $path = $this->endpoint . '/inApps/v1/history/' . $originalTransactionId;

        if (!empty($revision)) {
            $path .= '?revision=' . $revision;
        }

        return json_decode($this->getClient()->get($path, [
            'headers' => [
                'Authorization' => "Bearer " . $this->jwt($bundleId)
            ]
        ])->getBody()->getContents(), true);
    }

    public function subscriptions($originalTransactionId, $bundleId = null)
    {
        $path = $this->endpoint . '/inApps/v1/subscriptions/' . $originalTransactionId;

        return json_decode($this->getClient()->get($path, [
            'headers' => [
                'Authorization' => "Bearer " . $this->jwt($bundleId)
            ]
        ])->getBody()->getContents(), true);
    }

    public function transactionsConsumption($originalTransactionId, $requestBody, $bundleId = null)
    {
        $path = $this->endpoint . '/inApps/v1/transactions/consumption/' . $originalTransactionId;

        if ($requestBody instanceof ConsumptionRequest) {
            $requestBody = $requestBody->toArray();
        }

        return json_decode($this->getClient()->put($path, [
            'headers' => [
                'Authorization' => "Bearer " . $this->jwt($bundleId),
                'Content-Type' => 'application/json'
            ],
            'body' => $requestBody
        ])->getBody()->getContents(), true);
    }

    public function refundLookup($originalTransactionId, $bundleId = null)
    {
        $path = $this->endpoint . '/inApps/v1/refund/lookup/' . $originalTransactionId;

        return json_decode($this->getClient()->get($path, [
            'headers' => [
                'Authorization' => "Bearer " . $this->jwt($bundleId)
            ]
        ])->getBody()->getContents(), true);
    }

    public function subscriptionsExtend($originalTransactionId, $requestBody, $bundleId = null)
    {
        $path = $this->endpoint . '/inApps/v1/subscriptions/extend/' . $originalTransactionId;

        if ($requestBody instanceof ExtendRenewalDateRequest) {
            $requestBody = $requestBody->toArray();
        }

        return json_decode($this->getClient()->put($path, [
            'headers' => [
                'Authorization' => "Bearer " . $this->jwt($bundleId),
                'Content-Type' => 'application/json'
            ],
            'body' => $requestBody
        ])->getBody()->getContents(), true);
    }
}
