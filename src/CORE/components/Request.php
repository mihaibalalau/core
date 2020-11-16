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
    private $parameters = [];
    private $files = [];
    private $requestInfo = [];

    /**
     * @var Router $router
     */
    private $router;

    public function __construct(array $knownRoutes)
    {
        $json = json_decode(file_get_contents("php://input"), true) ?: [];
        parse_str(file_get_contents("php://input"), $url_encoded);

        $this->parameters = array_merge($_GET, $_POST, $json, $url_encoded);
        $this->requestInfo = $_SERVER;
        $this->router = new Router($knownRoutes, $this->requestInfo('REDIRECT_URL'), $this->requestInfo('REQUEST_METHOD'));
        $this->files = $_FILES;
    }

    public function parameters(string $key = null)
    {
        if ($key) {
            if (is_array($key)) {
                $r = [];

                foreach ($key as $prop) {
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


    public function requestInfo(string $key = null)
    {
        if ($key) {
            return isset($this->requestInfo[$key]) ? $this->requestInfo[$key] : null;
        }
        return $this->requestInfo;
    }

    public function files(string $key = null)
    {
        if ($key) {
            return isset($this->files[$key]) ? $this->files[$key] : null;
        }
        return $this->files;
    }

    public function Router(): Router
    {
        return $this->router;
    }
}