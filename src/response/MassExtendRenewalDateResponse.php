<?php

namespace yanlongli\AppStoreServerApi\response;

/**
 * @property string requestIdentifier A string that contains a unique identifier you provide to track each subscription-renewal-date extension request.
 * @since 1.7+
 */
class MassExtendRenewalDateResponse extends Response
{
    public function __construct($contents)
    {
        parent::__construct($contents);
        $arr = json_decode($contents, true);

        $this->requestIdentifier = $arr['requestIdentifier'];
    }
}