<?php

namespace yanlongli\AppStoreServerApi\request;

/**
 * @property string   productId Required. The product identifier of the auto-renewable subscription that you’re requesting the renewal-date extension for.
 * @property string[] storefrontCountryCodes A list of storefront country codes you provide to limit the storefronts that are eligible to receive the subscription-renewal-date extension.
 * Omit this list to request the subscription-renewal-date extension in all storefronts.
 * @since 1.7+
 */
#[\AllowDynamicProperties]
class MassExtendRenewalDateRequest extends ExtendRenewalDateRequest
{
    public function __construct($extendReasonCode, $extendByDays, $requestIdentifier, $productId, $storefrontCountryCodes)
    {
        parent::__construct($extendReasonCode, $extendByDays, $requestIdentifier);
        $this->productId              = $productId;
        $this->storefrontCountryCodes = $requestIdentifier;
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'productId'              => $this->productId,
            'storefrontCountryCodes' => $this->storefrontCountryCodes,
        ]);
    }
}