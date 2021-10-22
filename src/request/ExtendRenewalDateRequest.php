<?php

namespace yanlongli\AppStoreServerApi\request;

/**
 * @property int    extendReasonCode  The reason code for the subscription date extension.
 * 0 Undeclared; no information provided.
 * 1 The renewal-date extension is for customer satisfaction.
 * 2 The renewal-date extension is for other reasons.
 * 3 The renewal-date extension is due to a service issue or outage.
 * @property int    extendByDays      The number of days to extend the subscription renewal date.
 * The number of days is a number from 1 to 90.
 * @property string requestIdentifier A string that contains a unique identifier you provide to track each subscription-renewal-date-extension request.
 */
class ExtendRenewalDateRequest
{

    public function __construct($extendReasonCode, $extendByDays, $requestIdentifier)
    {
        $this->extendReasonCode = $extendReasonCode;
        $this->extendByDays = $extendByDays;
        $this->requestIdentifier = $requestIdentifier;
    }

    public function toArray()
    {
        return [
            'extendReasonCode' => $this->extendReasonCode,
            'extendByDays' => $this->extendByDays,
            'requestIdentifier' => $this->requestIdentifier,
        ];
    }
}
