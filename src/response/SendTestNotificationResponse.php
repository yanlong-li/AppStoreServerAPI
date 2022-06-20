<?php

namespace yanlongli\AppStoreServerApi\response;

/**
 * @property string $testNotificationToken
 */
class SendTestNotificationResponse extends Response
{
    public function __construct($contents)
    {
        parent::__construct($contents);
        $arr = json_decode($contents, JSON_OBJECT_AS_ARRAY);
        if (!$arr) {
            return;
        }
        $this->testNotificationToken = $arr['testNotificationToken'] ?? '';
    }
}
