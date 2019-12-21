<?php

class Application {

    /**
     * @var Configuration $configuration
     */
    private $configuration;
    private $environment;
    private $serverData;

    public function __construct(Configuration $configuration) {

        $this->configuration = $configuration;
        $this->setEnvironment();
        $this->setServerData();
    }

    private function setEnvironment()
    {
        foreach((array) $this->configuration->getEnvironments() as $env => $val) {

            if ((string) $val === $_SERVER['HTTP_HOST']) {

                $this->environment = $env;
            }
        }
    }

    public function setServerData()
    {
        $this->serverData = $this->configuration->getServers()->{$this->environment};
    }

    public function Configuration() {

        return $this->configuration;
    }

    public function getEnvironment()
    {
        return $this->environment;
    }

    public function getServerData()
    {
        return $this->serverData;
    }
}