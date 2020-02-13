<?php

abstract class Controller {

    /**
     * @var Application $application
     */
    protected $application;

    /**
     * @var Response $response
     */
    protected $response;

    /**
     * @var Request $request
     */
    protected $request;

    public function __construct(Application $application, Request $request, Response $response) {

        $this->application = $application;
        $this->request = $request;
        $this->response = $response;

        $this->run();
    }

    abstract protected function run();
}