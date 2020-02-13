<?php

abstract class AttributesFactory {

    /**
     * @var mixed $attributes
     */
    private $attributes;



    /**
     * @param string $name
     * @param $attribute
     */
    public function setAttribute(string $name, $attribute) {

        $this->attributes[$name] = $attribute;
    }


    /**
     * @param string $name
     * @return mixed | null
     */
    public function getAttribute(string $name) {

        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }


    /**
     * @return mixed
     */
    public function getAttributes() {

        return $this->attributes;
    }
}