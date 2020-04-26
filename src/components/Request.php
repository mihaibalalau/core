<?php
namespace CORE\Components;

use \CORE\Parts\Router;

/**
 * Class Request
 * @package CORE
 * CORE [1/3]
 *
 */
final class Request
{
    /**
     * @var array $parameters
     */
    private $parameters = [];

    private $requestInfo;

    /**
     * @var Router $router
     */
    private $router;

    public function __construct($knownRoutes)
    {
        $this->parameters = array_merge($_GET, $_POST);
        $this->requestInfo = $_SERVER;
        $this->router = new Router($knownRoutes, $this->requestInfo("REDIRECT_URL"));
    }

    public function parameters($key = null)
    {
        if ($key) {
            return isset($this->parameters[$key]) ? $this->parameters[$key] : null;
        }
        return $this->parameters;
    }

    /**
     * @param string $key
     * @return string|null
     */
    public function requestInfo($key = null)
    {
        if ($key) {
            return isset($this->requestInfo[$key]) ? $this->requestInfo[$key] : null;
        }
        return $this->requestInfo;
    }

    /**
     * @return Router
     */
    public function Router() : Router
    {
        return $this->router;
    }
}