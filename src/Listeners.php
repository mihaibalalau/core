<?php
namespace CORE;

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
            $this->listeners[substr($classname, strrpos("\\",) + 1)][] = $listener;
        }
    }
    public function engageApplicationListeners(Components\Application $application)
    {
        foreach($this->listeners['ApplicationListener'] as $applicationListeners) {
            new $applicationListeners($application);
        }
    }

    public function engageRequestListeners(Components\Application $application, Components\Request $request)
    {
        foreach ($this->listeners['RequestListener'] as $requestListener) {
            new $requestListener($application, $request);
        }
    }

    public function engageResponseListeners(Components\Application $application, Components\Request $request, Components\Response $response)
    {
        foreach ($this->listeners['ResponseListener'] as $responseListener) {
            new $responseListener($application, $request, $response);
        }
    }
}