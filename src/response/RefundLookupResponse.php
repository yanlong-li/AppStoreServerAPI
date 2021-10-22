<?php

namespace yanlongli\AppStoreServerApi\response;

/**
 * RefundLookupResponse
 * A response that contains an array of signed JSON Web Signature (JWS) transactions.
 * @link https://developer.apple.com/documentation/appstoreserverapi/refundlookupresponse
 * @property JWSTransaction[] signedTransactions An array of in-app purchase transactions that are part of order, signed by Apple, in JSON Web Signature format.
 */
class RefundLookupResponse extends Response
{
    /**
     * @param $contents
     */
    public function __construct($contents)
    {
        parent::__construct($contents);

        $arr = json_decode($contents, JSON_OBJECT_AS_ARRAY);
        if (!$arr) {
            return;
        }

        foreach ($arr['signedTransactions'] as $signedTransaction) {
            $this->signedTransactions[] = new JWSTransaction($signedTransaction);
        }
    }
}
