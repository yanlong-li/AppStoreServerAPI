<?php

namespace yanlongli\AppStoreServerApi\response;

/**
 * @property string         appAppleId
 * @property string         bundleId
 * @property string         bundleVersion
 * @property string         environment
 * @property JWSRenewalInfo signedRenewalInfo
 * @property JWSTransaction signedTransactionInfo
 *
 */
class JWSNotificationResponseBodyV2DecodedPayloadData
{
    public function __set($name, $value)
    {
        if ($name === 'signedRenewalInfo') {
            $this->signedRenewalInfo = new JWSRenewalInfo($value);
//            foreach ($value as $key => $item) {
//                $this->signedRenewalInfo->{$key} = $item;
//            }
        } elseif ($name === 'signedTransactionInfo') {
            $this->signedTransactionInfo = new JWSTransaction($value);
//            foreach ($value as $key => $item) {
//                $this->signedTransactionInfo->{$key} = $item;
//            }
        } else {
            $this->{$name} = $value;
        }
    }
}
