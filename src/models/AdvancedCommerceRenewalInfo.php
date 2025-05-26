<?php

namespace yanlongli\AppStoreServerApi\models;

/**
 * @property string                        consistencyToken
 * @property AdvancedCommerceDescriptors   descriptors
 * @property AdvancedCommerceRenewalItem[] items
 * @property string                        period
 * @property string                        requestReferenceId
 * @property string                        taxCode
 * @since 1.14+
 */
#[\AllowDynamicProperties]
class AdvancedCommerceRenewalInfo extends BaseObject
{
    public function getAttributeMappingClass(): array
    {
        return [
            'descriptors' => AdvancedCommerceDescriptors::class,
            'items'       => AdvancedCommerceRenewalItem::class
        ];
    }
}