<?php
namespace CORE\Components;

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

    public function __construct()
    {
        $this->parameters = array_merge($_GET, $_POST);
        $this->requestInfo = $_SERVER;
    }

    public function parameters($key = null)
    {
        if ($key) {
            return isset($this->parameters[$key]) ? $this->parameters[$key] : null;
        }
        return $this->parameters;
    }

    public function requestInfo($key = null)
    {
        if ($key) {
            return isset($this->requestInfo[$key]) ? $this->requestInfo[$key] : null;
        }
        return $this->requestInfo;
    }
}