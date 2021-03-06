<?php

namespace CORE\Tools\Listeners;

use CORE\Runnable;
use CORE\Components\Application;
use CORE\Components\Request;

abstract class RequestListener implements Runnable
{
    /**
     * @var Application $application
     */
    protected $application;

    /**
     * @var Request $request
     */
    protected $request;

    public function __construct(Application $application, Request $request)
    {
        $this->application = $application;
        $this->request = $request;
        $this->run();
    }
}