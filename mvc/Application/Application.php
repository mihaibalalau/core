<?php

class Application {

    /**
     * @var Configuration $configuration
     */
    private $configuration;

    public function __construct(Configuration $configuration) {

        $this->configuration = $configuration;

    }

    public function Configuration() {

        return $this->configuration;
    }
}