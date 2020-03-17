<?php
namespace CORE\Parts;
use CORE\Components\Application;
use CORE\Components\Request;
use CORE\Components\Response;

/**
 * Class Listeners
 * @package CORE
 *
 * The listener engine
 * Stores and runs the listeners based on their parent class
 *
 */
class Listeners
{
    private $listeners = [
        "ApplicationListener" => [],
        "RequestListener" => [],
        "ResponseListener" => []
    ];

    public function __construct($listeners, $path)
    {
        foreach($listeners as $listener) {
            require_once("{$path}/{$listener}.php");
            $classname = get_parent_class($listener);
            $this->listeners[substr($classname, strrpos($classname, "\\") + 1)][] = $listener;
        }
    }
    public function engageApplicationListeners(Application $application)
    {
        foreach($this->listeners['ApplicationListener'] as $applicationListeners) {
            new $applicationListeners($application);
        }
    }

    public function engageRequestListeners(Application $application, Request $request)
    {
        foreach ($this->listeners['RequestListener'] as $requestListener) {
            new $requestListener($application, $request);
        }
    }

    public function engageResponseListeners(Application $application, Request $request, Response $response)
    {
        foreach ($this->listeners['ResponseListener'] as $responseListener) {
            new $responseListener($application, $request, $response);
        }
    }
}