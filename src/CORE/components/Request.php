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
    /**
     * @var array $files
     */
    private $files = [];

    private $requestInfo;

    /**
     * @var Router $router
     */
    private $router;

    public function __construct($knownRoutes)
    {
        $json = json_decode(file_get_contents("php://input"), true) ? : [];

        $this->parameters = array_merge($_GET, $_POST, $json);
        $this->requestInfo = $_SERVER;
        $this->router = new Router($knownRoutes, $this->requestInfo("REDIRECT_URL"));
        $this->files = $_FILES['files'];
    }

    public function parameters($key = null)
    {
        if ($key) {
            if (is_array($key)) {
                $r = [];

                foreach ( $key as $prop ) {
                    if (isset($this->parameters[$prop])) {
                        $r[$prop] = $this->parameters[$prop];
                    }
                }

                return $r;
            } else {
                return isset($this->parameters[$key]) ? $this->parameters[$key] : null;
            }
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
     * @return array
     */
    public function files()
    {
        return $this->files;
    }

    /**
     * @return Router
     */
    public function Router(): Router
    {
        return $this->router;
    }
}