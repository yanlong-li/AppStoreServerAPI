<?php

namespace yanlongli\AppStoreServerApi\models;

/**
 * @since 1.14+
 */
#[\AllowDynamicProperties]
class AdvancedCommerceRenewalItem extends BaseObject
{
    /**
     * @var string
     */
    public $SKU;
    /**
     * @var string
     */
    public $description;
    /**
     * @var string
     */
    public $displayName;
    /** @var AdvancedCommerceOffer */
    public $offer;
    /**
     * @var int int64
     */
    public $price;

    public function getAttributeMappingClass(): array
    {
        return [
            'offer' => AdvancedCommerceOffer::class,
        ];
    }
}