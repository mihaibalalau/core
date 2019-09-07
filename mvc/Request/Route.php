<?php

class Route {

    private $URI;
    private $parameters;
    private $method;


    public function getURI() {

        return $this->URI;
    }

    public function setURI($URI) {

        $this->URI = $URI;
    }

    public function getParameters() {

        return $this->parameters;
    }

    public function setParameters($parameters) {

        $this->parameters = $parameters;
    }
    public function getMethod() {

        return $this->method;
    }

    public function setMethod($method) {

        $this->method = $method;
    }



}