<?php

namespace yanlongli\AppStoreServerApi\request;

class ConsumptionRequest
{
    // The age of the customer’s account.
    public $accountTenure;
    // The UUID of the in-app user account that completed the consumable in-app purchase transaction.
    public $appAccountToken;
    // A value that indicates the extent to which the customer consumed the in-app purchase.
    public $consumptionStatus;
    // A Boolean value that indicates whether the customer consented to provide consumption data.
    public $customerConsented;
    // A value that indicates whether the app successfully delivered an in-app purchase that works properly.
    public $deliveryStatus;
    // A value that indicates the total amount, in USD, of in-app purchases the customer has made in your app, across all platforms.
    public $lifetimeDollarsPurchased;
    // A value that indicates the total amount, in USD, of refunds the customer has received, in your app, across all platforms.
    public $lifetimeDollarsRefunded;
    // A value that indicates the platform on which the customer consumed the in-app purchase.
    public $platform;
    // A value that indicates the amount of time that the customer used the app.
    public $playTime;
    // A Boolean value that indicates whether you provided, prior to its purchase, a free sample or trial of the content, or information about its functionality.
    public $sampleContentProvided;
    // The status of the customer’s account.
    public $userStatus;

    public function toArray()
    {
        return [

        ];
    }
}
