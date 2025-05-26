<?php

namespace yanlongli\AppStoreServerApi\response;


/**
 */
#[\AllowDynamicProperties]
class JWSTransaction
{

    /**
     * @var string
     */
    public $jws = '';

    /**
     * @var JWSTransactionDecodedPayload
     */
    public $payload;

    public function __construct($jws)
    {
        $this->jws = $jws;

        $this->payload = new JWSTransactionDecodedPayload($this->getPayloadToArray());
    }


    protected function getPayloadToArray()
    {
        $jwsArr = explode(".", $this->jws);
        if (isset($jwsArr[1])) {
            return json_decode(base64_decode($jwsArr[1]), true)?:[];
        }
        return [];
    }

    public function __get($name)
    {
        return $this->payload[$name];
    }

    public function __toString()
    {
        return $this->jws;
    }
}
