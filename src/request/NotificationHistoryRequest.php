<?php

namespace yanlongli\AppStoreServerApi\request;


class NotificationHistoryRequest
{
    public $originalTransactionId = '';
    public $notificationType = '';
    public $notificationSubtype = '';
    public $startDate;
    public $endDate;

    /**
     * @param $startDate
     * @param $endDate
     */
    public function __construct($startDate, $endDate)
    {

        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function toArray()
    {
        return array_filter([
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'originalTransactionId' => $this->originalTransactionId,
            'notificationType' => $this->notificationType,
            'notificationSubtype' => $this->notificationSubtype,
        ], function ($val) {
            return !empty($val);
        });
    }
}
