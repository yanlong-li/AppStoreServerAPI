<?php

namespace yanlongli\AppStoreServerApi;

use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use yanlongli\AppStoreServerApi\request\ConsumptionRequest;
use yanlongli\AppStoreServerApi\request\ExtendRenewalDateRequest;
use yanlongli\AppStoreServerApi\response\ExtendRenewalDateResponse;
use yanlongli\AppStoreServerApi\response\HistoryResponse;
use yanlongli\AppStoreServerApi\response\OrderLookupResponse;
use yanlongli\AppStoreServerApi\response\RefundLookupResponse;
use yanlongli\AppStoreServerApi\response\StatusResponse;

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

    protected function jwt($bundleId = null)
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
     * @throws GuzzleException
     */
    protected function get($path, $bundleId = null)
    {
        return $this->getClient()->get($this->endpoint . $path, [
            'headers' => [
                'Authorization' => "Bearer " . $this->jwt($bundleId)
            ]
        ])->getBody()->getContents();
    }

    /**
     * @throws GuzzleException
     */
    protected function put($path, $body, $bundleId = null)
    {
        return $this->getClient()->put($path, [
            'headers' => [
                'Authorization' => "Bearer " . $this->jwt($bundleId),
                'Content-Type' => 'application/json'
            ],
            'body' => $body
        ])->getBody()->getContents();
    }

    /**
     * Order ID Lookup
     * @return OrderLookupResponse ["status"=>0,"signedTransactions"=>[JWS]]
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
     * @throws GuzzleException
     * @link https://developer.apple.com/documentation/appstoreserverapi/look_up_order_id Look Up Order ID
     * @link https://developer.apple.com/documentation/appstoreserverapi/orderlookupresponse OrderLookupResponse
     */
    public function lookup($orderId, $bundleId = null)
    {
        return new OrderLookupResponse(
            $this->get('/inApps/v1/lookup/' . $orderId,
                $bundleId
            )
        );
    }

    /**
     * Get Transaction History
     * @throws GuzzleException
     */
    public function history($originalTransactionId, $revision = '', $bundleId = null)
    {
        $path = '/inApps/v1/history/' . $originalTransactionId;

        if (!empty($revision)) {
            $path .= '?revision=' . $revision;
        }

        return new HistoryResponse(
            $this->get($path,
                $bundleId
            )
        );
    }

    /**
     * Get Subscription Status
     * @throws GuzzleException
     */
    public function subscriptions($originalTransactionId, $bundleId = null)
    {
        $path = '/inApps/v1/subscriptions/' . $originalTransactionId;

        return new StatusResponse($this->get($path, $bundleId));
    }

    /**
     * Consumption Information
     * @param string                   $originalTransactionId
     * @param ConsumptionRequest|array $requestBody
     * @param ?string                  $bundleId
     * @return void
     * @throws GuzzleException
     */
    public function transactionsConsumption($originalTransactionId, $requestBody, $bundleId = null)
    {
        $path = '/inApps/v1/transactions/consumption/' . $originalTransactionId;

        if ($requestBody instanceof ConsumptionRequest) {
            $requestBody = $requestBody->toArray();
        }

        $this->put($path, $requestBody, $bundleId);
    }

    /**
     * Refund Lookup
     * @throws GuzzleException
     */
    public function refundLookup($originalTransactionId, $bundleId = null)
    {
        $path = '/inApps/v1/refund/lookup/' . $originalTransactionId;

        return new RefundLookupResponse($this->get($path, $bundleId));
    }

    /**
     * Extend a Subscription Renewal Date
     * @param string                         $originalTransactionId
     * @param ExtendRenewalDateRequest|array $requestBody
     * @param ?string                        $bundleId
     * @return ExtendRenewalDateResponse
     * @throws GuzzleException
     */
    public function subscriptionsExtend($originalTransactionId, $requestBody, $bundleId = null)
    {
        $path = '/inApps/v1/subscriptions/extend/' . $originalTransactionId;

        if ($requestBody instanceof ExtendRenewalDateRequest) {
            $requestBody = $requestBody->toArray();
        }
        return new ExtendRenewalDateResponse($this->put($path, $requestBody, $bundleId));
    }
}
