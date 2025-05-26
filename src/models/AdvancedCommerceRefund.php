<?php

namespace yanlongli\AppStoreServerApi\models;

/**
 * @since 1.14+
 */
#[\AllowDynamicProperties]
class AdvancedCommerceRefund extends BaseObject
{
    /** @var int advancedCommerceRefundAmount int64 */
    public $refundAmount;
    /** @var int advancedCommerceRefundDate timestamp */
    public $refundDate;
    /** @var string advancedCommerceRefundReason */
    public $refundReason;
    /** @var string advancedCommerceRefundType */
    public $refundType;
}