<?php

namespace yanlongli\AppStoreServerApi\response;

/**
 * @property string attemptDate
 * @property string sendAttemptResult
 */
#[\AllowDynamicProperties]
class SendAttemptItem
{
    public function __construct($attemptDate, $sendAttemptResult)
    {
        $this->attemptDate       = $attemptDate;
        $this->sendAttemptResult = $sendAttemptResult;
    }
}