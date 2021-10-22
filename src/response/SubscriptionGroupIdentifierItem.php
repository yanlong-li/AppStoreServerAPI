<?php

namespace yanlongli\AppStoreServerApi\response;

/**
 * SubscriptionGroupIdentifierItem
 * Subscription information, including signed transaction information and signed renewal information, for one subscription group.
 * @link https://developer.apple.com/documentation/appstoreserverapi/subscriptiongroupidentifieritem
 */
class SubscriptionGroupIdentifierItem
{

    /**
     * The identifier of the subscription group that the subscription belongs to.
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/subscriptiongroupidentifier
     */
    public $subscriptionGroupIdentifier;

    /**
     * @var LastTransactionsItem[]
     */
    public $lastTransactions;

    public function __construct($subscriptionGroupIdentifier, $lastTransactions)
    {
        $this->subscriptionGroupIdentifier = $subscriptionGroupIdentifier;
        $this->lastTransactions = $lastTransactions;
    }
}
