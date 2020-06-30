<?php
namespace CORE\Tools;
use CORE\Runnable;
use CORE\Components\Application;
use CORE\Components\Request;
use CORE\Components\Response;

abstract class Controller implements Runnable
{
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

    public function __construct(Application $application, Request $request, Response $response)
    {
        $this->application = $application;
        $this->request = $request;
        $this->response = $response;
    }
}