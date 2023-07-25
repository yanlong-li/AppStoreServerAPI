<?php

namespace yanlongli\AppStoreServerApi\response;
/**
 * @property NotificationHistoryResponseItem[] notificationHistory
 * @property boolean                           hasMore
 * @property string                            paginationToken
 */
class NotificationHistoryResponse extends Response
{
    public function __construct($contents)
    {
        parent::__construct($contents);
        $arr = json_decode($contents, true);
        if (!$arr) {
            return;
        }
        $this->paginationToken = $arr['paginationToken'] ?? '';
        $this->hasMore         = $arr['hasMore'] ?? false;
        foreach ($arr['notificationHistory'] as $item) {
            $this->notificationHistory[] = new NotificationHistoryResponseItem($item['signedPayload'], $item['sendAttempts']);
        }
    }
}
