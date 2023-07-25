<?php

namespace yanlongli\AppStoreServerApi;

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
    /** @var RestClient */
    protected $restClient;

    /**
     * @param RestClient $restClient
     *
     * @link https://developer.apple.com/documentation/appstoreserverapi/creating_api_keys_to_use_with_the_app_store_server_api
     *       private and issuerid see
     */
    public function __construct(RestClient $restClient)
    {
        $this->restClient = $restClient;
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
    public function lookupOrderId($orderId)
    {
        return new OrderLookupResponse(
            $this->restClient->requestGetContents('/inApps/v1/lookup/' . $orderId
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
    public function getTransactionHistory($transactionId, $params = '', $bundleId = null)
    {
        $path = '/inApps/v1/history/' . $transactionId;

        if (is_array($params)) {
            $path .= '?' . http_build_query($params);
        } elseif (!empty($params)) {
            $path .= '?revision=' . $params;
        }

        return new HistoryResponse(
            $this->restClient->requestGetContents($path
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
    public function getAllSubscriptionStatuses($transactionId, $params = [], $bundleId = null)
    {
        $path = '/inApps/v1/subscriptions/' . $transactionId;

        if (!empty($params)) {
            $path .= '?' . http_build_query($params);
        }
        return new StatusResponse($this->restClient->requestGetContents($path));
    }

    /**
     * Get Transaction Info
     *
     * @param string  $transactionId
     * @param ?string $bundleId
     *
     * @since 1.8+
     * @link  https://developer.apple.com/documentation/appstoreserverapi/get_transaction_info?changes=latest_minor
     */
    public function getTransactionInfo($transactionId, $bundleId = null)
    {
        $path = '/inApps/v1/transactions/' . $transactionId;

        return new TransactionInfoResponse($this->restClient->requestGetContents($path));
    }

    /**
     * Send Consumption Information
     *
     * @param string                   $transactionId transactionId or originalTransactionId
     * @param ConsumptionRequest|array $requestBody
     * @param ?string                  $bundleId
     *
     * @return void
     * @since 1.0+
     */
    public function sendConsumptionInformation($transactionId, $requestBody, $bundleId = null)
    {
        $path = '/inApps/v1/transactions/consumption/' . $transactionId;

        if ($requestBody instanceof ConsumptionRequest) {
            $requestBody = $requestBody->toArray();
        }

        return $this->restClient->requestPut($path, $requestBody);
    }

    /**
     * Get Refund History
     *
     * Get a paginated list of all of a customer’s refunded in-app purchases for your app.
     * App Store Server API 1.6+
     *
     * @param string $transactionId transactionId or originalTransactionId
     * @param        $bundleId
     *
     * @return RefundHistoryResponse
     * @since 1.6+
     */
    public function getRefundHistory($transactionId, $bundleId = null)
    {
        $path = '/inApps/v2/refund/lookup/' . $transactionId;
        return new RefundHistoryResponse($this->restClient->requestGetContents($path));
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
    public function extendASubscriptionRenewalDate($originalTransactionId, $requestBody)
    {
        $path = '/inApps/v1/subscriptions/extend/' . $originalTransactionId;

        if ($requestBody instanceof ExtendRenewalDateRequest) {
            $requestBody = $requestBody->toArray();
        }
        return new ExtendRenewalDateResponse($this->restClient->requestPutContents($path, $requestBody));
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
    public function extendSubscriptionRenewalDatesForAllActiveSubscribers($requestBody)
    {
        $path = '/inApps/v1/subscriptions/extend/mass/';

        if ($requestBody instanceof MassExtendRenewalDateRequest) {
            $requestBody = $requestBody->toArray();
        }
        return new MassExtendRenewalDateResponse($this->restClient->requestPostContents($path, $requestBody));
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
    public function getStatusOfSubscriptionRenewalDateExtensions($requestIdentifier, $productId)
    {
        $path = "/inApps/v1/subscriptions/extend/mass/{$requestIdentifier}/{$productId}";

        return new MassExtendRenewalDateStatusResponse($this->restClient->requestGetContents($path));
    }


    /**
     * @param                                  $requestBody
     * @param string                           $paginationToken
     * @param ?string                          $bundleId
     *
     * @return NotificationHistoryResponse
     * @since 1.5+
     * @link  https://developer.apple.com/documentation/appstoreserverapi/get_notification_history
     */
    public function getNotificationHistory($requestBody, $paginationToken = '', $bundleId = null)
    {
        $path = '/inApps/v1/notifications/history';
        if (!empty($paginationToken)) {
            $path .= '?paginationToken=' . $paginationToken;
        }
        if ($requestBody instanceof NotificationHistoryRequest) {
            $requestBody = $requestBody->toArray();
        }
        return new NotificationHistoryResponse($this->restClient->requestPostContents($path, $requestBody));
    }

    public function notificationsTest($bundleId = null)
    {
        return new NotificationHistoryResponse($this->restClient->requestPostContents('/inApps/v1/notifications/test', []));
    }
}
