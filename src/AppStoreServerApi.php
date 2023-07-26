<?php

namespace yanlongli\AppStoreServerApi;

use Psr\Http\Message\ResponseInterface;
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
use yanlongli\AppStoreServerApi\response\StatusResponse;
use yanlongli\AppStoreServerApi\response\TransactionInfoResponse;

class AppStoreServerApi
{
    /**
     * @var Config
     */
    protected $config;


    /**
     * @param Config $config
     *
     * @link https://developer.apple.com/documentation/appstoreserverapi/creating_api_keys_to_use_with_the_app_store_server_api
     *       private and issuerid see
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
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
     * @link  https://developer.apple.com/documentation/appstoreserverapi/look_up_order_id Look Up Order ID
     * @link  https://developer.apple.com/documentation/appstoreserverapi/orderlookupresponse OrderLookupResponse
     * @since 1.1+
     */
    public function lookupOrderId($orderId): OrderLookupResponse
    {
        return new OrderLookupResponse(
            $this->requestGetContents('/inApps/v1/lookup/' . $orderId
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
     * @since 1.0+
     * @link  https://developer.apple.com/documentation/appstoreserverapi/get_transaction_history?changes=latest_minor
     *       Document
     *
     */
    public function getTransactionHistory(string $transactionId, $params = ''): HistoryResponse
    {
        $path = '/inApps/v1/history/' . $transactionId;

        if (is_array($params)) {
            $path .= '?' . http_build_query($params);
        } elseif (!empty($params)) {
            $path .= '?revision=' . $params;
        }

        return new HistoryResponse(
            $this->requestGetContents($path
            )
        );
    }

    /**
     * Get All Subscription Statuses
     *
     * @param string $transactionId transactionId or originalTransactionId
     *
     * @link  https://developer.apple.com/documentation/appstoreserverapi/get_all_subscription_statuses?changes=latest_minor
     * @since 1.0+
     */
    public function getAllSubscriptionStatuses(string $transactionId, $params = []): StatusResponse
    {
        $path = '/inApps/v1/subscriptions/' . $transactionId;

        if (!empty($params)) {
            $path .= '?' . http_build_query($params);
        }
        return new StatusResponse($this->requestGetContents($path));
    }

    /**
     * Get Transaction Info
     *
     * @param string $transactionId
     *
     * @return TransactionInfoResponse
     * @since 1.8+
     * @link  https://developer.apple.com/documentation/appstoreserverapi/get_transaction_info?changes=latest_minor
     */
    public function getTransactionInfo(string $transactionId): TransactionInfoResponse
    {
        $path = '/inApps/v1/transactions/' . $transactionId;

        return new TransactionInfoResponse($this->requestGetContents($path));
    }

    /**
     * Send Consumption Information
     *
     * @param string                   $transactionId transactionId or originalTransactionId
     * @param ConsumptionRequest|array $requestBody
     *
     * @since 1.0+
     */
    public function sendConsumptionInformation(string $transactionId, $requestBody): ResponseInterface
    {
        $path = '/inApps/v1/transactions/consumption/' . $transactionId;

        if ($requestBody instanceof ConsumptionRequest) {
            $requestBody = $requestBody->toArray();
        }

        return $this->requestPut($path, $requestBody);
    }

    /**
     * Get Refund History
     *
     * Get a paginated list of all of a customer’s refunded in-app purchases for your app.
     * App Store Server API 1.6+
     *
     * @param string $transactionId transactionId or originalTransactionId
     *
     * @return RefundHistoryResponse
     * @since 1.6+
     */
    public function getRefundHistory(string $transactionId): RefundHistoryResponse
    {
        $path = '/inApps/v2/refund/lookup/' . $transactionId;
        return new RefundHistoryResponse($this->requestGetContents($path));
    }

    /**
     * Extend a Subscription Renewal Date
     *
     * Extends the renewal date of a customer’s active subscription using the original transaction identifier.
     *
     * @param string                         $originalTransactionId
     * @param ExtendRenewalDateRequest|array $requestBody
     *
     * @return ExtendRenewalDateResponse
     * @since 1.1+
     */
    public function extendASubscriptionRenewalDate(string $originalTransactionId, $requestBody): ExtendRenewalDateResponse
    {
        $path = '/inApps/v1/subscriptions/extend/' . $originalTransactionId;

        if ($requestBody instanceof ExtendRenewalDateRequest) {
            $requestBody = $requestBody->toArray();
        }
        return new ExtendRenewalDateResponse($this->requestPutContents($path, $requestBody));
    }

    /**
     * Extend Subscription Renewal Dates for All Active Subscribers
     *
     * Uses a subscription’s product identifier to extend the renewal date for all of its eligible active subscribers.
     *
     * @param ExtendRenewalDateRequest|array $requestBody
     *
     * @return MassExtendRenewalDateResponse
     * @since 1.7+
     * @link  https://developer.apple.com/documentation/appstoreserverapi/extend_subscription_renewal_dates_for_all_active_subscribers
     */
    public function extendSubscriptionRenewalDatesForAllActiveSubscribers($requestBody): MassExtendRenewalDateResponse
    {
        $path = '/inApps/v1/subscriptions/extend/mass/';

        if ($requestBody instanceof MassExtendRenewalDateRequest) {
            $requestBody = $requestBody->toArray();
        }
        return new MassExtendRenewalDateResponse($this->requestPostContents($path, $requestBody));
    }

    /**
     * Get Status of Subscription Renewal Date Extensions
     *
     * Checks whether a renewal date extension request completed, and provides the final count of successful or failed
     * extensions.
     *
     * @param string $requestIdentifier
     * @param string $productId
     *
     * @return MassExtendRenewalDateStatusResponse
     * @since 1.7+
     * @link  https://developer.apple.com/documentation/appstoreserverapi/get_status_of_subscription_renewal_date_extensions
     */
    public function getStatusOfSubscriptionRenewalDateExtensions(string $requestIdentifier, string $productId): MassExtendRenewalDateStatusResponse
    {
        $path = "/inApps/v1/subscriptions/extend/mass/$requestIdentifier/$productId";

        return new MassExtendRenewalDateStatusResponse($this->requestGetContents($path));
    }


    /**
     * @param                                  $requestBody
     * @param string                           $paginationToken
     *
     * @return NotificationHistoryResponse
     * @since 1.5+
     * @link  https://developer.apple.com/documentation/appstoreserverapi/get_notification_history
     */
    public function getNotificationHistory($requestBody, string $paginationToken = ''): NotificationHistoryResponse
    {
        $path = '/inApps/v1/notifications/history';
        if (!empty($paginationToken)) {
            $path .= '?paginationToken=' . $paginationToken;
        }
        if ($requestBody instanceof NotificationHistoryRequest) {
            $requestBody = $requestBody->toArray();
        }
        return new NotificationHistoryResponse($this->requestPostContents($path, $requestBody));
    }

    public function notificationsTest(): NotificationHistoryResponse
    {
        return new NotificationHistoryResponse($this->requestPostContents('/inApps/v1/notifications/test', []));
    }


    protected function requestGet($path): ResponseInterface
    {
        return $this->config->getHttpClient()->get($path);
    }

    protected function requestGetContents($path): string
    {
        return $this->requestGet($path)->getBody()->getContents();
    }

    protected function requestPut($path, $body): ResponseInterface
    {
        return $this->config->getHttpClient()->put($path, [
            'json' => $body
        ]);
    }

    protected function requestPutContents($path, $body): string
    {
        return $this->requestPut($path, $body)->getBody()->getContents();
    }

    protected function requestPost($path, $body): ResponseInterface
    {
        return $this->config->getHttpClient()->post($path, [
            'json' => $body,
        ]);
    }

    protected function requestPostContents($path, $body): string
    {
        return $this->requestPost($path, $body)->getBody()->getContents();
    }

    public function setConfig(Config $config): AppStoreServerApi
    {
        $this->config = $config;
        return $this;
    }

    public function getConfig(): Config
    {
        return $this->config;
    }
}
