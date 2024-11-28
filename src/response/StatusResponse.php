<?php

namespace yanlongli\AppStoreServerApi\response;

/**
 * StatusResponse
 * A response that contains status information for all of a customer’s subscriptions in your app.
 * @property string                            environment
 * @property string                            bundleId
 * @property int                               appAppleId
 * @property SubscriptionGroupIdentifierItem[] data
 *
 * @link https://developer.apple.com/documentation/appstoreserverapi/statusresponse
 */
#[\AllowDynamicProperties]
class StatusResponse extends Response
{
    /**
     * @param $contents
     */
    public function __construct($contents)
    {
        parent::__construct($contents);

        $arr = json_decode($contents, true);
        if (!$arr) {
            return;
        }
        $this->appAppleId = $arr['appAppleId'] ?? null;
        $this->bundleId = $arr['bundleId'];
        $this->environment = $arr['environment'];

        foreach ($arr['data'] as $subscriptionGroupIdentifierItem) {

            $lastTransactions = [];

            foreach ($subscriptionGroupIdentifierItem['lastTransactions'] as $lastTransaction) {
                $lastTransactions[] = new LastTransactionsItem(
                    $lastTransaction['originalTransactionId'],
                    $lastTransaction['status'],
                    $lastTransaction['signedRenewalInfo'],
                    $lastTransaction['signedTransactionInfo']
                );
            }

            $this->data[] = new SubscriptionGroupIdentifierItem(
                $subscriptionGroupIdentifierItem['subscriptionGroupIdentifier'],
                $lastTransactions
            );
        }
    }
}
