<?php

namespace yanlongli\AppStoreServerApi\models;

#[\AllowDynamicProperties]
class AdvancedCommerceTransactionInfo extends BaseObject
{
    /**
     * @var AdvancedCommerceDescriptors
     */
    public $descriptors;
    /** @var int64 advancedCommerceEstimatedTax */
    public $estimatedTax;
    /** @var AdvancedCommerceTransactionItems[] */
    public $items;
    /**
     * @var string advancedCommercePeriod
     */
    public $period;
    /** @var string advancedCommerceRequestReferenceId */
    public $requestReferenceId;
    /** @var string advancedCommerceTaxCode */
    public $taxCode;
    /** @var int64 advancedCommerceTaxExclusivePrice */
    public $taxExclusivePrice;
    /** @var string advancedCommerceTaxRate */
    public $taxRate;


    public static function getAttributeMappingClass()
    {
        return [
            'descriptors' => AdvancedCommerceDescriptors::class,
            'items'       => AdvancedCommerceTransactionItems::class
        ];
    }
}