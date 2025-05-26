<?php

namespace yanlongli\AppStoreServerApi\models;

/**
 * @since 1.14+
 */
#[\AllowDynamicProperties]
class AdvancedCommerceOffer extends BaseObject
{
    /**
     * @var string
     */
    public $period;
    /**
     * @var int
     */
    public $periodCount;
    /**
     * @var int int64
     */
    public $price;
    /**
     * @var string
     */
    public $reason;
}