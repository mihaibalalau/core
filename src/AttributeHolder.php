<?php
namespace CORE;

abstract class AttributeHolder
{
    private $attributes = [];

    public function attributes($key = null, $value = null)
    {
        $arg_count = func_num_args();
        switch ($arg_count) {
            case 2:
                $this->attributes[$key] = $value;
                break;
            case 1:
                return isset($this->attributes[$key]) ? $this->attributes[$key] : null;
                break;
            default:
                return $this->attributes;
        }
    }
}