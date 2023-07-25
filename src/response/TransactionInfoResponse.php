<?php


namespace yanlongli\AppStoreServerApi\response;

/**
 * @property JWSTransaction $signedTransactionInfo
 */
class TransactionInfoResponse extends Response
{
    public function __construct($contents)
    {
        parent::__construct($contents);

        $this->signedTransactionInfo = new JWSTransaction($contents);
    }
}