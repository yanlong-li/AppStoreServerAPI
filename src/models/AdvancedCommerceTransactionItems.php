<?php

namespace yanlongli\AppStoreServerApi\models;

/**
 * @since 1.14+
 */
#[\AllowDynamicProperties]
class AdvancedCommerceTransactionItems extends BaseObject
{
    public $SKU;
    public $description;
    public $displayName;
    /**
     * @var AdvancedCommerceOffer
     */
    public $offer;
    // @var int64
    public $price;
    /** @var AdvancedCommerceRefund[] */
    public $refunds;
    /**
     * @var string timestamp
     */
    public $revocationDate;

    public function getAttributeMappingClass()
    {
        return [
            'offer'   => AdvancedCommerceOffer::class,
            'refunds' => AdvancedCommerceRefund::class
        ];
    }
}