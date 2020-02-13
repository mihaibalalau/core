<?php

abstract class ApplicationListener implements Runnable {

    /**
     * @var Application $application
     */
    protected $application;

    public function __construct(Application $application) {
        $this->application = $application;

        $this->run();
    }

}