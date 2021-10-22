<?php

namespace yanlongli\AppStoreServerApi\response;

class JWSTransaction
{

    /**
     * @var string
     */
    public $content = '';

    public function getPayload()
    {
        $jwsArr = explode(".", $this->content);
        if (isset($jwsArr[1])) {
            return json_decode(base64_decode($jwsArr[1]), true);
        }
        return false;
    }

    public function __toString()
    {
        return $this->content;
    }
}
