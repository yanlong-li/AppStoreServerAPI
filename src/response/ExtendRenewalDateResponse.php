<?php

namespace yanlongli\AppStoreServerApi\response;

class ExtendRenewalDateResponse extends Response
{
    /** @var string timestamp */
    public $effectiveDate;
    /** @var string */
    public $originalTransactionId;
    /** @var bool */
    public $success;
    /** @var string */
    public $webOrderLineItemId;

    public function __construct($contents)
    {
        parent::__construct($contents);
        $arr                         = json_decode($contents, true);
        $this->effectiveDate         = $arr['effectiveDate'];
        $this->originalTransactionId = $arr['originalTransactionId'];
        $this->success               = $arr['success'];
        $this->webOrderLineItemId    = $arr['webOrderLineItemId'];
    }
}
