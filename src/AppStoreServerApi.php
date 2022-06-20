<?php

namespace yanlongli\AppStoreServerApi;

use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use yanlongli\AppStoreServerApi\request\ConsumptionRequest;
use yanlongli\AppStoreServerApi\request\ExtendRenewalDateRequest;
use yanlongli\AppStoreServerApi\request\NotificationHistoryRequest;
use yanlongli\AppStoreServerApi\response\ExtendRenewalDateResponse;
use yanlongli\AppStoreServerApi\response\HistoryResponse;
use yanlongli\AppStoreServerApi\response\NotificationHistoryResponse;
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
        return $this->getClient()->put($this->endpoint . $path, [
            'headers' => [
                'Authorization' => "Bearer " . $this->jwt($bundleId),
                'Content-Type' => 'application/json'
            ],
            'body' => $body
        ])->getBody()->getContents();
    }

    protected function post($path, $body, $bundleId = null)
    {
        var_dump($path);
        return $this->getClient()->post($this->endpoint . $path, [
            'headers' => [
                'Authorization' => "Bearer " . $this->jwt($bundleId),
            ],
            'json' => $body,
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
     * @param string|array $params string for revision,array with key=>value <br/>
     *                             startDate<br/>
     *                             An optional start date of the timespan for the transaction history records you’re requesting. The startDate must precede the endDate if you specify both dates. To be included in results, the transaction's purchaseDate must be equal to or greater than the startDate.<br/>
     *                             endDate<br/>
     *                             An optional end date of the timespan for the transaction history records you’re requesting. Choose an endDate that’s later than the startDate if you specify both dates. Using an endDate in the future is valid. To be included in results, the transaction’s purchaseDate must be less than the endDate.<br/>
     *                             productId<br/>
     *                             An optional filter that indicates the product identifier to include in the transaction history. Your query may specify more than one productID.<br/>
     *                             productType<br/>
     *                             An optional filter that indicates the product type to include in the transaction history. Your query may specify more than one productType.<br/>
     *                             Possible values: AUTO_RENEWABLE, NON_RENEWABLE, CONSUMABLE, NON_CONSUMABLE<br/>
     *                             sort<br/>
     *                             An optional sort order for the transaction history records. The response sorts the transaction records by their recently modified date. The default value is ASCENDING, so you receive the oldest records first. <br/>
     *                             Possible values: ASCENDING, DESCENDING<br/>
     *                             subscriptionGroupIdentifier<br/>
     *                             An optional filter that indicates the subscription group identifier to include in the transaction history. Your query may specify more than one subscriptionGroupIdentifier.<br/>
     *                             inAppOwnershipType<br/>
     *                             An optional filter that limits the transaction history by the in-app ownership type.<br/>
     *                             excludeRevoked<br/>
     *                             An optional Boolean value that indicates whether the transaction history excludes refunded and revoked transactions. The default value is false. <br/>
     *                             Possible values: true, false<br/>
     * @throws GuzzleException
     */
    public function history($originalTransactionId, $params = '', $bundleId = null)
    {
        $path = '/inApps/v1/history/' . $originalTransactionId;

        if (is_array($params)) {
            $path .= '?' . http_build_query($params);
        } elseif (!empty($params)) {
            $path .= '?revision=' . $params;
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

    /**
     * @param NotificationHistoryRequest|array $params paginationToken
     * @param                                  $bundleId
     */
    public function notificationHistory($requestBody, $paginationToken = '', $bundleId = null)
    {
        $path = '/inApps/v1/notifications/history';
        if (!empty($paginationToken)) {
            $path .= '?paginationToken=' . $paginationToken;
        }
        if ($requestBody instanceof NotificationHistoryRequest) {
            $requestBody = $requestBody->toArray();
        }
        return $this->post($path, $requestBody, $bundleId);
    }

    public function notificationsTest($bundleId = null)
    {
        return new NotificationHistoryResponse($this->post('/inApps/v1/notifications/test', [], $bundleId));
    }
}
