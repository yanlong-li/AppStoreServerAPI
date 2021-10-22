<?php

namespace yanlongli\AppStoreServerApi\response;

class JWSRenewalInfo
{
    /**
     * @var string
     */
    public $jws = '';

    /**
     * @var JWSRenewalInfoDecodedPayload
     */
    public $payload;

    public function __construct($jws)
    {
        $this->jws = $jws;
        $this->payload = new JWSRenewalInfoDecodedPayload();
        foreach ($this->getPayloadToArray() as $key => $value) {
            $this->payload->{$key} = $value;
        }
    }


    protected function getPayloadToArray()
    {
        $jwsArr = explode(".", $this->jws);
        if (isset($jwsArr[1])) {
            return json_decode(base64_decode($jwsArr[1]), true);
        }
        return false;
    }

    public function __toString()
    {
        return $this->jws;
    }
}
