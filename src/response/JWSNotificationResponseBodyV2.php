<?php

namespace yanlongli\AppStoreServerApi\response;

class JWSNotificationResponseBodyV2
{
    /**
     * @var string
     */
    public $jws = '';

    /**
     * @var JWSNotificationResponseBodyV2DecodedPayload
     */
    public $payload;

    public function __construct($jws)
    {
        $this->jws = $jws;
        $this->payload = new JWSNotificationResponseBodyV2DecodedPayload();
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
