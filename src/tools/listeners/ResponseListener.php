<?php
namespace CORE\Tools\Listeners;
use CORE\Runnable;
use CORE\Components\Application;
use CORE\Components\Request;
use CORE\Components\Response;

abstract class ResponseListener implements Runnable
{
    /**
     * @var Application $application
     */
    protected $application;

    /**
     * @var Request $request
     */
    protected $request;

    /**
     * @var Response $response
     */
    protected $response;

    public function __construct(Application $application, Request $request, Response $response)
    {
        $this->application = $application;
        $this->request = $request;
        $this->response = $response;
        $this->run();
    }
}