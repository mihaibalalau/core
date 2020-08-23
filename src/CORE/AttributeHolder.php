<?php

namespace CORE;

abstract class AttributeHolder
{
    private $attributes = [];

    public function attributes($key = null, $value = null, $fill = false)
    {
        $arg_count = func_num_args();
        switch ($arg_count) {
            case 2:
                if ($fill) {
                    return $this->attributes = $value;
                } else {
                    return $this->attributes[$key] = $value;
                }
            case 1:
                return isset($this->attributes[$key]) ? $this->attributes[$key] : null;
            default:
                return $this->attributes;
        }
    }
}