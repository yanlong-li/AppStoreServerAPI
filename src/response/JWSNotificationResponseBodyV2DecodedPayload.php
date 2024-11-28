<?php

namespace yanlongli\AppStoreServerApi\response;

/**
 * @property string                                          $notificationType
 * @property string                                          $subtype
 * @property string                                          $notificationUUID
 * @property string                                          $notificationVersion
 * @property JWSNotificationResponseBodyV2DecodedPayloadData $data
 * @property string                                          $version
 * @property string                                          $signedDate
 * @property $storefront
 * @property $storefrontId
 *
 */
#[\AllowDynamicProperties]
class JWSNotificationResponseBodyV2DecodedPayload
{
    const NOTIFICATION_TYPE_CONSUMPTION_REQUEST = 'CONSUMPTION_REQUEST';
    const NOTIFICATION_TYPE_DID_CHANGE_RENEWAL_PREF = 'DID_CHANGE_RENEWAL_PREF';
    const NOTIFICATION_TYPE_DID_CHANGE_RENEWAL_STATUS = 'DID_CHANGE_RENEWAL_STATUS';
    const NOTIFICATION_TYPE_DID_FAIL_TO_RENEW = 'DID_FAIL_TO_RENEW';
    const NOTIFICATION_TYPE_DID_RENEW = 'DID_RENEW';
    const NOTIFICATION_TYPE_EXPIRED = 'EXPIRED';
    const NOTIFICATION_TYPE_GRACE_PERIOD_EXPIRED = 'GRACE_PERIOD_EXPIRED';
    const NOTIFICATION_TYPE_OFFER_REDEEMED = 'OFFER_REDEEMED';
    const NOTIFICATION_TYPE_PRICE_INCREASE = 'PRICE_INCREASE';
    const NOTIFICATION_TYPE_REFUND = 'REFUND';
    const NOTIFICATION_TYPE_REFUND_DECLINED = 'REFUND_DECLINED';
    const NOTIFICATION_TYPE_RENEWAL_EXTENDED = 'RENEWAL_EXTENDED';
    const NOTIFICATION_TYPE_REVOKE = 'REVOKE';
    const NOTIFICATION_TYPE_SUBSCRIBED = 'SUBSCRIBED';
    const NOTIFICATION_TYPE_TEST = 'TEST';


    const SUB_TYPE_INITIAL_BUY = 'INITIAL_BUY';
    const SUB_TYPE_RESUBSCRIBE = 'RESUBSCRIBE';
    const SUB_TYPE_DOWNGRADE = 'DOWNGRADE';
    const SUB_TYPE_UPGRADE = 'UPGRADE';
    const SUB_TYPE_AUTO_RENEW_ENABLED = 'AUTO_RENEW_ENABLED';
    const SUB_TYPE_AUTO_RENEW_DISABLED = 'AUTO_RENEW_DISABLED';
    const SUB_TYPE_VOLUNTARY = 'VOLUNTARY';
    const SUB_TYPE_BILLING_RETRY = 'BILLING_RETRY';
    const SUB_TYPE_PRICE_INCREASE = 'PRICE_INCREASE';
    const SUB_TYPE_GRACE_PERIOD = 'GRACE_PERIOD';
    const SUB_TYPE_BILLING_RECOVERY = 'BILLING_RECOVERY';
    const SUB_TYPE_PENDING = 'PENDING';
    const SUB_TYPE_ACCEPTED = 'ACCEPTED';
    const SUB_TYPE_TEST = 'TEST';

    public function __set($name, $value)
    {
        if ($name === 'data') {
            $this->data = new JWSNotificationResponseBodyV2DecodedPayloadData();
            foreach ($value as $key => $item) {
                $this->data->{$key} = $item;
            }
        } else {
            $this->{$name} = $value;
        }
    }
}
