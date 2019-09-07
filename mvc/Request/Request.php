<?php

/**
 * Class Request
 *
 * Wrapper class over the request data sent by the client
 *
 */
final class Request extends AttributesFactory {

    /**
     * @var Route $route
     */
    private $route;

    /**
     * @var array $parameters
     */
    private $parameters;

    public function __construct() {

        $this->setRoute();
        $this->setParameters();
    }

    private function setRoute() {

        $route = new Route();

        $requestURI = strpos($_SERVER['REDIRECT_URL'], '/') === 0 ? substr($_SERVER['REDIRECT_URL'], 1) : $_SERVER['REDIRECT_URL'];

        $route->setURI($requestURI);
        $route->setMethod($_SERVER['REQUEST_METHOD']);

        $this->route = $route;
    }

    public function Route() {

        return $this->route;
    }

    private function setParameters() {

        switch($_SERVER['REQUEST_METHOD']) {

            case 'GET':
                $this->parameters = $_GET;
                break;
            case 'POST':
                $this->parameters = $_POST;
                break;
            default:
                $this->parameters = [];
        }
    }

    public function getParameters() {

        return $this->parameters;
    }

    public function getParameter($name) {

        return isset($this->parameters[$name]) ? $this->parameters[$name] : null;
    }

}