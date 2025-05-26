<?php

namespace yanlongli\AppStoreServerApi\models;
/**
 * @method array getAttributeMappingClass
 */
#[\AllowDynamicProperties]
class BaseObject
{

    public function __construct($config = [])
    {
        $classMap = method_exists(static::class, 'getAttributeMappingClass') ? static::getAttributeMappingClass() : [];

        foreach ($config as $key => $value) {
            if (isset($classMap[$key])) {
                $_classMap = [];
                if (is_string($classMap[$key])) {
                    $class = $classMap[$key];
                } else {
                    $class     = $classMap[$key][0];
                    $_classMap = $classMap[$key];
                }
                if (isset($value[0])) {
                    $this->$key = [];
                    foreach ($value as $v)
                        $this->$key[] = new $class($v, $_classMap);
                } else
                    $this->$key = new $class($value, $_classMap);
            } else
                $this->$key = $value;
        }
    }
}