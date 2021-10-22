<?php

namespace yanlongli\AppStoreServerApi\response;

abstract class Response
{
    /**
     * @var string raw response contents
     */
    protected $contents;

    /**
     * @param string $contents
     */
    public function __construct($contents)
    {
        $this->contents = $contents;
    }

    /**
     * @return string
     */
    public function getRawContents()
    {
        return $this->contents;
    }
}
