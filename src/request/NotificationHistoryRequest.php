<?php

namespace yanlongli\AppStoreServerApi\request;


class NotificationHistoryRequest
{
    public $transactionId = '';
    public $notificationType = '';
    public $notificationSubtype = '';
    public $startDate;
    public $endDate;
    /**
     * @var bool A Boolean value that indicates whether the response includes only notifications that failed to reach your server.
     */
    public $onlyFailures;

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
            'transactionId' => $this->transactionId,
            'notificationType' => $this->notificationType,
            'notificationSubtype' => $this->notificationSubtype,
        ], function ($val) {
            return !empty($val);
        });
    }
}
