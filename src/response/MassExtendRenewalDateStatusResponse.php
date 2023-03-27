<?php

namespace yanlongli\AppStoreServerApi\response;

/**
 * @property string  requestIdentifier The UUID that represents your request for a subscription-renewal-date extension.
 * Maximum Length: 128
 * @property boolean complete A Boolean value that’s TRUE to indicate that the App Store completed your request to extend a subscription renewal date for all eligible subscribers.
 * The value is FALSE if the request is in progress.
 * @property ?string completeDate The date that the App Store completes the request.
 * Appears only if complete is TRUE.
 * @property ?int    failedCount The final count of subscribers that fail to receive a subscription-renewal-date extension.
 * Appears only if complete is TRUE.
 * @property ?int    succeededCount The final count of subscribers that successfully receive a subscription-renewal-date extension.
 * Appears only if complete is TRUE.
 * @since 1.7+
 */
class MassExtendRenewalDateStatusResponse extends Response
{
    public function __construct($contents)
    {
        parent::__construct($contents);
        $arr                     = json_decode($contents, true);
        $this->requestIdentifier = $arr['requestIdentifier'];
        $this->complete          = $arr['complete'];
        $this->completeDate      = $arr['completeDate'] ?? null;
        $this->failedCount       = $arr['failedCount'] ?? null;
        $this->succeededCount    = $arr['succeededCount'] ?? null;
    }
}