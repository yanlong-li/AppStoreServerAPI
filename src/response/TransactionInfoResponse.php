<?php


namespace yanlongli\AppStoreServerApi\response;

/**
 */
class TransactionInfoResponse extends Response
{
    /**
     * @var JWSTransaction
     */
    public $signedTransactionInfo;

    public function __construct($contents)
    {
        parent::__construct($contents);

        $this->signedTransactionInfo = new JWSTransaction($contents);
    }
}