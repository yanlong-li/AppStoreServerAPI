<?php

namespace yanlongli\AppStoreServerApi\request;

class ConsumptionRequest
{

    /**
     * @param int    $accountTenure            The age of the customer’s account.<br/>
     *                                         Possible Values<br/>
     *                                         0 Account age is undeclared.<br/>
     *                                         1 Account age is between 0–3 days.<br/>
     *                                         2 Account age is between 3–10 days.<br/>
     *                                         3 Account age is between 10–30 days.<br/>
     *                                         4 Account age is between 30–90 days.<br/>
     *                                         5 Account age is between 90–180 days.<br/>
     *                                         6 Account age is between 180–365 days.<br/>
     *                                         7 Account age is over 365 days.<br/>
     * @param string $appAccountToken          The UUID of the in-app user account that completed the consumable in-app
     *                                         purchase transaction.
     * @param int    $consumptionStatus        A value that indicates the extent to which the customer consumed the
     *                                         in-app purchase.<br/> Possible Values<br/>
     *                                         0 The consumption status is undeclared.<br/>
     *                                         1 The in-app purchase is not consumed.<br/>
     *                                         2 The in-app purchase is partially consumed.<br/>
     *                                         3 The in-app purchase is fully consumed<br/>
     * @param bool   $customerConsented        A Boolean value that indicates whether the customer consented to provide
     *                                         consumption data.
     * @param int    $deliveryStatus           A value that indicates whether the app successfully delivered an in-app
     *                                         purchase that works properly. <br/> Possible Values <br/>
     *                                         0 The app delivered the consumable in-app purchase and it’s working
     *                                         properly.<br/>
     *                                         1 The app didn’t deliver the consumable in-app purchase due to a quality
     *                                         issue.<br/>
     *                                         2 The app delivered the wrong item.<br/>
     *                                         3 The app didn’t deliver the consumable in-app purchase due to a server
     *                                         outage.<br/>
     *                                         4 The app didn’t deliver the consumable in-app purchase due to an
     *                                         in-game currency change.<br/>
     *                                         5 The app didn’t deliver the consumable in-app purchase for other
     *                                         reasons.<br/>
     * @param int    $lifetimeDollarsPurchased A value that indicates the total amount, in USD, of in-app purchases the
     *                                         customer has made in your app, across all platforms.<br/> Possible
     *                                         Values <br/>
     *                                         0 Lifetime purchase amount is undeclared.<br/>
     *                                         1 Lifetime purchase amount is 0 USD.<br/>
     *                                         2 Lifetime purchase amount is between 0.01–49.99 USD.<br/>
     *                                         3 Lifetime purchase amount is between 50–99.99 USD.<br/>
     *                                         4 Lifetime purchase amount is between 100–499.99 USD.<br/>
     *                                         5 Lifetime purchase amount is between 500–999.99 USD.<br/>
     *                                         6 Lifetime purchase amount is between 1000–1999.99 USD.<br/>
     *                                         7 Lifetime purchase amount is over 2000 USD.<br/>
     * @param int    $lifetimeDollarsRefunded  A value that indicates the dollar amount of refunds the customer has
     *                                         received in your app, since purchasing the app, across all platforms.
     *                                         <br/> Possible Values <br/>
     *                                         0 Lifetime refund amount is undeclared.<br/>
     *                                         1 Lifetime refund amount is 0 USD.<br/>
     *                                         2 Lifetime refund amount is between 0.01–49.99 USD.<br/>
     *                                         3 Lifetime refund amount is between 50–99.99 USD.<br/>
     *                                         4 Lifetime refund amount is between 100–499.99 USD.<br/>
     *                                         5 Lifetime refund amount is between 500–999.99 USD.<br/>
     *                                         6 Lifetime refund amount is between 1000–1999.99 USD.<br/>
     *                                         7 Lifetime refund amount is over 2000 USD.<br/>
     * @param int    $platform                 The platform on which the customer consumed the in-app purchase. <br/>
     *                                         Possible Values <br/>
     *                                         0 Undeclared. <br/>
     *                                         1 An Apple platform. <br/>
     *                                         2 Non-Apple platform. <br/>
     * @param int    $playTime                 A value that indicates the amount of time that the customer used the
     *                                         app.<br/> Possible Values <br/>
     *                                         0 The engagement time is undeclared. <br/>
     *                                         1 The engagement time is between 0–5 minutes. <br/>
     *                                         2 The engagement time is between 5–60 minutes. <br/>
     *                                         3 The engagement time is between 1–6 hours. <br/>
     *                                         4 The engagement time is between 6–24 hours. <br/>
     *                                         5 The engagement time is between 1–4 days. <br/>
     *                                         6 The engagement time is between 4–16 days. <br/>
     *                                         7 The engagement time is over 16 days. <br/>
     * @param bool   $sampleContentProvided    A Boolean value that indicates whether you provided, prior to its
     *                                         purchase, a free sample or trial of the content, or information about
     *                                         its functionality. <br/>
     * @param int    $userStatus               The status of a customer’s account within your app.<br/>
     *                                         Possible Values <br/>
     *                                         0 Account status is undeclared.<br/>
     *                                         1 The customer’s account is active.<br/>
     *                                         2 The customer’s account is suspended.<br/>
     *                                         3 The customer’s account is terminated.<br/>
     *                                         4 The customer’s account has limited access.<br/>
     */
    public function __construct(
        $accountTenure,
        $appAccountToken,
        $consumptionStatus,
        $customerConsented,
        $deliveryStatus,
        $lifetimeDollarsPurchased,
        $lifetimeDollarsRefunded,
        $platform,
        $playTime,
        $sampleContentProvided,
        $userStatus
    )
    {
        $this->accountTenure            = $accountTenure;
        $this->appAccountToken          = $appAccountToken;
        $this->consumptionStatus        = $consumptionStatus;
        $this->customerConsented        = $customerConsented;
        $this->deliveryStatus           = $deliveryStatus;
        $this->lifetimeDollarsPurchased = $lifetimeDollarsPurchased;
        $this->lifetimeDollarsRefunded  = $lifetimeDollarsRefunded;
        $this->platform                 = $platform;
        $this->playTime                 = $playTime;
        $this->sampleContentProvided    = $sampleContentProvided;
        $this->userStatus               = $userStatus;
    }

    /**
     * @var int The age of the customer’s account.<br/>
     * Possible Values<br/>
     * 0 Account age is undeclared.<br/>
     * 1 Account age is between 0–3 days.<br/>
     * 2 Account age is between 3–10 days.<br/>
     * 3 Account age is between 10–30 days.<br/>
     * 4 Account age is between 30–90 days.<br/>
     * 5 Account age is between 90–180 days.<br/>
     * 6 Account age is between 180–365 days.<br/>
     * 7 Account age is over 365 days.<br/>
     */
    public $accountTenure;

    /**
     * @var string The UUID of the in-app user account that completed the consumable in-app purchase transaction.
     */
    public $appAccountToken;

    /**
     * @var int A value that indicates the extent to which the customer consumed the in-app purchase.<br/>
     * Possible Values<br/>
     * 0 The consumption status is undeclared.<br/>
     * 1 The in-app purchase is not consumed.<br/>
     * 2 The in-app purchase is partially consumed.<br/>
     * 3 The in-app purchase is fully consumed<br/>
     */
    public $consumptionStatus;

    /**
     * @var bool A Boolean value that indicates whether the customer consented to provide consumption data.
     */
    public $customerConsented;

    /**
     * @var int A value that indicates whether the app successfully delivered an in-app purchase that works properly.
     *      <br/> Possible Values <br/>
     *      0 The app delivered the consumable in-app purchase and it’s working properly.<br/>
     *      1 The app didn’t deliver the consumable in-app purchase due to a quality issue.<br/>
     *      2 The app delivered the wrong item.<br/>
     *      3 The app didn’t deliver the consumable in-app purchase due to a server outage.<br/>
     *      4 The app didn’t deliver the consumable in-app purchase due to an in-game currency change.<br/>
     *      5 The app didn’t deliver the consumable in-app purchase for other reasons.<br/>
     */
    public $deliveryStatus;

    /**
     * @var int A value that indicates the total amount, in USD, of in-app purchases the customer has made in your app,
     *      across all platforms.<br/> Possible Values <br/>
     *      0 Lifetime purchase amount is undeclared.<br/>
     *      1 Lifetime purchase amount is 0 USD.<br/>
     *      2 Lifetime purchase amount is between 0.01–49.99 USD.<br/>
     *      3 Lifetime purchase amount is between 50–99.99 USD.<br/>
     *      4 Lifetime purchase amount is between 100–499.99 USD.<br/>
     *      5 Lifetime purchase amount is between 500–999.99 USD.<br/>
     *      6 Lifetime purchase amount is between 1000–1999.99 USD.<br/>
     *      7 Lifetime purchase amount is over 2000 USD.<br/>
     */
    public $lifetimeDollarsPurchased;

    /**
     * @var int A value that indicates the dollar amount of refunds the customer has received in your app, since
     *      purchasing the app, across all platforms. <br/> Possible Values <br/>
     *      0 Lifetime refund amount is undeclared.<br/>
     *      1 Lifetime refund amount is 0 USD.<br/>
     *      2 Lifetime refund amount is between 0.01–49.99 USD.<br/>
     *      3 Lifetime refund amount is between 50–99.99 USD.<br/>
     *      4 Lifetime refund amount is between 100–499.99 USD.<br/>
     *      5 Lifetime refund amount is between 500–999.99 USD.<br/>
     *      6 Lifetime refund amount is between 1000–1999.99 USD.<br/>
     *      7 Lifetime refund amount is over 2000 USD.<br/>
     */
    public $lifetimeDollarsRefunded;
    /**
     * @var int The platform on which the customer consumed the in-app purchase. <br/>
     * Possible Values <br/>
     * 0 Undeclared. <br/>
     * 1 An Apple platform. <br/>
     * 2 Non-Apple platform. <br/>
     */
    public $platform;

    /**
     * @var int A value that indicates the amount of time that the customer used the app.<br/>
     * Possible Values <br/>
     * 0 The engagement time is undeclared. <br/>
     * 1 The engagement time is between 0–5 minutes. <br/>
     * 2 The engagement time is between 5–60 minutes. <br/>
     * 3 The engagement time is between 1–6 hours. <br/>
     * 4 The engagement time is between 6–24 hours. <br/>
     * 5 The engagement time is between 1–4 days. <br/>
     * 6 The engagement time is between 4–16 days. <br/>
     * 7 The engagement time is over 16 days. <br/>
     */
    public $playTime;
    /**
     * @var int A value that indicates your preferred outcome for the refund request.
     *          0 The refund preference is undeclared. Use this value to avoid providing information for this field.
     *          1 You prefer that Apple grants the refund.
     *          2 You prefer that Apple declines the refund.
     *          3 You have no preference whether Apple grants or declines the refund.
     */
    public $refundPreference = 0;
    /**
     * @var bool  A Boolean value that indicates whether you provided, prior to its purchase, a free sample or trial of
     *      the content, or information about its functionality. <br/> Boolean 值，指示您在购买之前是否提供了内容的免费示例或试用，或者有关其功能的信息。
     */
    public $sampleContentProvided;

    /**
     * @var int The status of a customer’s account within your app.<br/>
     * Possible Values <br/>
     * 0 Account status is undeclared.<br/>
     * 1 The customer’s account is active.<br/>
     * 2 The customer’s account is suspended.<br/>
     * 3 The customer’s account is terminated.<br/>
     * 4 The customer’s account has limited access.<br/>
     */
    public $userStatus;

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            "accountTenure"            => $this->accountTenure,
            "appAccountToken"          => $this->appAccountToken,
            "consumptionStatus"        => $this->consumptionStatus,
            "customerConsented"        => $this->customerConsented,
            "deliveryStatus"           => $this->deliveryStatus,
            "lifetimeDollarsPurchased" => $this->lifetimeDollarsPurchased,
            "lifetimeDollarsRefunded"  => $this->lifetimeDollarsRefunded,
            "platform"                 => $this->platform,
            "playTime"                 => $this->playTime,
            'refundPreference'         => $this->refundPreference,
            "sampleContentProvided"    => $this->sampleContentProvided,
            "userStatus"               => $this->userStatus,
        ];
    }
}
