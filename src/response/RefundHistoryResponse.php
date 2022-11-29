<?php

namespace yanlongli\AppStoreServerApi\response;
/**
 * @property boolean          $hasMore  是否还有更多
 * @property string           $revision 获取后续记录的凭据
 * @property JWSTransaction[] $signedTransactions
 */
class RefundHistoryResponse extends Response
{
    /**
     * @param $contents
     */
    public function __construct($contents)
    {
        parent::__construct($contents);

        $arr = json_decode($contents, true);
        if (!$arr) {
            return;
        }

        foreach ($arr['signedTransactions'] as $signedTransaction) {
            $this->signedTransactions[] = new JWSTransaction($signedTransaction);
        }
    }
}
