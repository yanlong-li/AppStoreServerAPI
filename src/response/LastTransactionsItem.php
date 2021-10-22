<?php

namespace yanlongli\AppStoreServerApi\response;
/**
 * The most recent signed transaction information and signed renewal information for a subscription.
 * @link https://developer.apple.com/documentation/appstoreserverapi/lasttransactionsitem
 */
class LastTransactionsItem
{

    /**
     * The original transaction identifier of a purchase.
     * @var string
     * @link https://developer.apple.com/documentation/appstoreserverapi/originaltransactionid
     */
    public $originalTransactionId;

    /**
     * The subscripton status.
     * @var int
     * Possible Values
     * 1 The subscripton is active.<br/>
     * 2 The subscription is expired.<br/>
     * 3 The subscription is in a billing retry period.<br/>
     * 4 The subscription is in a billing grace period.<br/>
     * 5 The subscription is revoked.
     * @link https://developer.apple.com/documentation/appstoreserverapi/status
     */
    public $status;
    /**
     * @var JWSRenewalInfo
     */
    public $signedRenewalInfo;

    /**
     * @var JWSTransaction
     */
    public $signedTransactionInfo;

    public function __construct($originalTransactionId, $status, $signedRenewalInfo, $signedTransactionInfo)
    {
        $this->originalTransactionId = $originalTransactionId;
        $this->status = $status;
        $this->signedRenewalInfo = new JWSRenewalInfo($signedRenewalInfo);
        $this->signedTransactionInfo = new JWSTransaction($signedTransactionInfo);
    }
}
