<?php

namespace yanlongli\AppStoreServerApi\response;

/**
 * @property string effectiveDate timestamp
 * @property string originalTransactionId
 * @property bool   success
 * @property string webOrderLineItemId
 */
class ExtendRenewalDateResponse extends Response
{
    public function __construct($contents)
    {
        parent::__construct($contents);
        $arr = json_decode($contents, true);
        $this->effectiveDate = $arr['effectiveDate'];
        $this->originalTransactionId = $arr['originalTransactionId'];
        $this->success = $arr['success'];
        $this->webOrderLineItemId = $arr['webOrderLineItemId'];
    }
}
