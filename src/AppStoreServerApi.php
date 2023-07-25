<?php

namespace yanlongli\AppStoreServerApi;

use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use yanlongli\AppStoreServerApi\request\ConsumptionRequest;
use yanlongli\AppStoreServerApi\request\ExtendRenewalDateRequest;
use yanlongli\AppStoreServerApi\request\MassExtendRenewalDateRequest;
use yanlongli\AppStoreServerApi\request\NotificationHistoryRequest;
use yanlongli\AppStoreServerApi\response\ExtendRenewalDateResponse;
use yanlongli\AppStoreServerApi\response\HistoryResponse;
use yanlongli\AppStoreServerApi\response\MassExtendRenewalDateResponse;
use yanlongli\AppStoreServerApi\response\MassExtendRenewalDateStatusResponse;
use yanlongli\AppStoreServerApi\response\NotificationHistoryResponse;
use yanlongli\AppStoreServerApi\response\OrderLookupResponse;
use yanlongli\AppStoreServerApi\response\RefundHistoryResponse;
use yanlongli\AppStoreServerApi\response\RefundLookupResponse;
use yanlongli\AppStoreServerApi\response\StatusResponse;
use yanlongli\AppStoreServerApi\response\TransactionInfoResponse;

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
     *
     * @link https://developer.apple.com/documentation/appstoreserverapi/creating_api_keys_to_use_with_the_app_store_server_api
     *       private and issuerid see
     */
    public function __construct($endpoint, $privateKeyId, $privateKey, $issuerId, $bundleId = null)
    {
        $this->endpoint     = $endpoint;
        $this->privateKeyId = $privateKeyId;
        $this->privateKey   = $privateKey;
        $this->issuerId     = $issuerId;
        $this->bundleId     = $bundleId;
    }

    protected function jwt($bundleId = null)
    {
        $payload = [
            'iss'   => $this->issuerId,
            "iat"   => time() - 10,
            "exp"   => time() + 3590,
            "aud"   => "appstoreconnect-v1",
            "nonce" => $this->uuid(),
            "bid"   => $bundleId ?: $this->bundleId,
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

    protected function get($path, $bundleId = null)
    {
        return $this->getClient()->get($this->endpoint . $path, [
            'headers' => [
                'Authorization' => "Bearer " . $this->jwt($bundleId)
            ]
        ])->getBody()->getContents();
    }

    protected function put($path, $body, $bundleId = null)
    {
        return $this->getClient()->put($this->endpoint . $path, [
            'headers' => [
                'Authorization' => "Bearer " . $this->jwt($bundleId),
                'Content-Type'  => 'application/json'
            ],
            'body'    => $body
        ])->getBody()->getContents();
    }

    protected function post($path, $body, $bundleId = null)
    {
        var_dump($path);
        return $this->getClient()->post($this->endpoint . $path, [
            'headers' => [
                'Authorization' => "Bearer " . $this->jwt($bundleId),
            ],
            'json'    => $body,
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
     * The request failed. This may be due to a temporary outage. Check the specific error message for further
     * information.
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
     *
     * @param string       $transactionId (Required) The identifier of a transaction that belongs to the customer, and
     *                                    which may be an original transaction identifier (originalTransactionId).
     * @param string|array $params
     *
     * @link https://developer.apple.com/documentation/appstoreserverapi/get_transaction_history?changes=latest_minor
     *       Document
     *
     */
    public function history($transactionId, $params = '', $bundleId = null)
    {
        $path = '/inApps/v1/history/' . $transactionId;

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
     *
     * @param string $transactionId transactionId or originalTransactionId
     * @link https://developer.apple.com/documentation/appstoreserverapi/get_all_subscription_statuses?changes=latest_minor
     */
    public function subscriptions($transactionId, $params = [], $bundleId = null)
    {
        $path = '/inApps/v1/subscriptions/' . $transactionId;

        if (!empty($params)) {
            $path .= '?' . http_build_query($params);
        }
        return new StatusResponse($this->get($path, $bundleId));
    }

    /**
     * Get Transaction Info
     *
     * @param string  $transactionId
     * @param ?string $bundleId
     *
     * @since 1.8+
     */
    public function getTransactionInfo($transactionId, $bundleId = null)
    {
        $path = '/inApps/v1/transactions/' . $transactionId;

        return new TransactionInfoResponse($this->get($path, $bundleId));
    }

    /**
     * Consumption Information
     *
     * @param string                   $transactionId transactionId or originalTransactionId
     * @param ConsumptionRequest|array $requestBody
     * @param ?string                  $bundleId
     *
     * @return void
     * @throws GuzzleException
     */
    public function transactionsConsumption($transactionId, $requestBody, $bundleId = null)
    {
        $path = '/inApps/v1/transactions/consumption/' . $transactionId;

        if ($requestBody instanceof ConsumptionRequest) {
            $requestBody = $requestBody->toArray();
        }

        $this->put($path, $requestBody, $bundleId);
    }

    /**
     * Get Refund History
     *
     * Get a paginated list of all of a customer’s refunded in-app purchases for your app.
     * App Store Server API 1.6+
     *
     * @param string $transactionId transactionId or originalTransactionId
     * @param $bundleId
     *
     * @return RefundHistoryResponse
     * @throws GuzzleException
     * @since 1.6+
     */
    public function refundLookupV2($transactionId, $bundleId = null)
    {
        $path = '/inApps/v2/refund/lookup/' . $transactionId;
        return new RefundHistoryResponse($this->get($path, $bundleId));
    }

    /**
     * Extend a Subscription Renewal Date
     *
     * Extends the renewal date of a customer’s active subscription using the original transaction identifier.
     *
     * @param string                         $originalTransactionId
     * @param ExtendRenewalDateRequest|array $requestBody
     * @param ?string                        $bundleId
     *
     * @return ExtendRenewalDateResponse
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
     * Extend Subscription Renewal Dates for All Active Subscribers
     *
     * Uses a subscription’s product identifier to extend the renewal date for all of its eligible active subscribers.
     *
     * @param ExtendRenewalDateRequest|array $requestBody
     * @param ?string                        $bundleId
     *
     * @return MassExtendRenewalDateResponse
     * @throws GuzzleException
     * @since 1.7+
     */
    public function extendSubscriptionRenewalDatesForAllActiveSubscribers($requestBody, $bundleId = null)
    {
        $path = '/inApps/v1/subscriptions/extend/mass/';

        if ($requestBody instanceof MassExtendRenewalDateRequest) {
            $requestBody = $requestBody->toArray();
        }
        return new MassExtendRenewalDateResponse($this->post($path, $requestBody, $bundleId));
    }

    /**
     * Get Status of Subscription Renewal Date Extensions
     *
     * Checks whether a renewal date extension request completed, and provides the final count of successful or failed
     * extensions.
     *
     * @param string  $requestIdentifier
     * @param string  $productId
     * @param ?string $bundleId
     *
     * @return MassExtendRenewalDateStatusResponse
     * @throws GuzzleException
     * @since 1.7+
     */
    public function getStatusOfSubscriptionRenewalDateExtensions($requestIdentifier, $productId, $bundleId = null)
    {
        $path = "/inApps/v1/subscriptions/extend/mass/{$requestIdentifier}/{$productId}";

        return new MassExtendRenewalDateStatusResponse($this->get($path, $bundleId));
    }


    /**
     * @param                                  $requestBody
     * @param string                           $paginationToken
     * @param ?string                          $bundleId
     *
     * @return NotificationHistoryResponse
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
        return new NotificationHistoryResponse($this->post($path, $requestBody, $bundleId));
    }

    public function notificationsTest($bundleId = null)
    {
        return new NotificationHistoryResponse($this->post('/inApps/v1/notifications/test', [], $bundleId));
    }
}
