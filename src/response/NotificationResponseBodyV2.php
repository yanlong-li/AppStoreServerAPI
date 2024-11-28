<?php

namespace yanlongli\AppStoreServerApi\response;
/**
 * @property JWSNotificationResponseBodyV2 signedPayload
 */
#[\AllowDynamicProperties]
class NotificationResponseBodyV2
{
    public function __construct($signedPayload)
    {
        $this->signedPayload = new JWSNotificationResponseBodyV2($signedPayload);
    }
}
