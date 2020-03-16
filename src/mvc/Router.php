<?php
namespace CORE;

/**
 * Class Router
 * @package CORE
 */
class Router
{
    private $route;

    public function __construct($routes, $requestURI)
    {
        foreach ($routes as $route) {
            if ($route->url === $requestURI) {
                $this->route = $route;
            }
        }
        if (!$this->route) {
            $this->route = $routes[count($routes) - 1];
        }
    }
    public function getRoute()
    {
        return $this->route;
    }
}