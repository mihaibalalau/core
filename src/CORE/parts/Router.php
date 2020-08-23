<?php

namespace CORE\Parts;

use Exception;

/**
 * Class Router
 * @package CORE
 */
class Router
{
    private $route;
    private $parameters = [];
    private $matchCase;

    public function __construct($routes, $requestURI)
    {
        // Test each route in config.json
        foreach ($routes as $route) {
            $this->matchCase = isset($route->match_case) ? $route->match_case : true;

            // If route is namespaced - i.e. is a group of routes sharing a prefix ( /prefix/my/route )
            if (isset($route->namespace)) {
                if ($result = $this->testNamespaceRoute($route, $requestURI)) {
                    $this->route = $result;
                }
                // If route has parameters attempt to match and extract
            } else if (strpos($route->url, '%')) {
                $parameters = $this->testParamRoute($route->url, $requestURI);

                if ($parameters) {
                    $this->parameters = $parameters;
                    $this->route = $route;
                    break;
                }

                // If simple route attempt to match
            } else {
                if ($this->matchCase) {
                    if ($route->url === $requestURI) {
                        $this->route = $route;
                        break;
                    }
                } else {
                    if (strtolower($route->url) === strtolower($requestURI)) {
                        $this->route = $route;
                        break;
                    }
                }
            }
        }
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function pathParameters($key = null)
    {
        if ($key) {
            return isset($this->parameters[$key]) ? $this->parameters[$key] : null;
        }
        return $this->parameters;
    }

    private function testNamespaceRoute($namespace, $requested)
    {
        // Test namespace
        if (strpos($requested, $namespace->namespace) !== false) {

            // Test each route in the namespace
            foreach ($namespace->routes as $route) {
                // Test if route is also a namespace
                if (isset($route->namespace)) {
                    $clone = clone $route;
                    $clone->namespace = $namespace->namespace . $clone->namespace;
                    $clone->controllers = $namespace->controllers . '/' . $clone->controllers;
                    $clone->views = $namespace->views . '/' . $clone->views;

                    if ($result = $this->testNamespaceRoute($clone, $requested)) {
                        return $result;
                    }
                } else if ($namespace->namespace . $route->url === $requested) {
                    $clone = clone $route;
                    $clone->url = $namespace->namespace . $clone->url;
                    $clone->controller = $namespace->controllers . '/' . $clone->controller;
                    $clone->view = $namespace->views . '/' . $clone->view;

                    return $clone;
                }
            }
        }

        return false;
    }

    private function testParamRoute($known, $requested)
    {
        static $parameters = [];

        for ($i = $j = 0; $i < strlen($known) && $j < strlen($requested); $i++, $j++) {
            if ($known[$i] === '%') {
                $param_name = '';
                $new_i = $this->parseParameterName(substr($known, $i), $param_name) + 1 + $i;
                if ($new_i === strlen($known)) {
                    $parameters[$param_name] = substr($requested, $j);
                    return $parameters;
                } else {
                    $param_value = $requested[$j++]; // Assign at least one character
                    while ($j < strlen($requested)) {
                        $is_successful = true;
                        if ($known[$new_i] === $requested[$j]) {
                            $parameters[$param_name] = $param_value;
                            $is_successful = $this->try(substr($known, $new_i), substr($requested, $j));
                            if (!$is_successful) {
                                unset($parameters[$param_name]);
                            } else {
                                return $parameters ?: true;
                            }
                        }
                        if ($known[$new_i] !== $requested[$j] || !$is_successful) {
                            $param_value .= $requested[$j++];
                        }
                    }
                    return false;
                }
            } elseif ($known[$i] === $requested[$j]) {
                continue;
            } elseif ($this->matchCase) {
                return false;
            } else {
                if (strtolower($known[$i]) === strtolower($requested[$j])) {
                    continue;
                } else {
                    return false;
                }
            }
        }

        if (isset($known[$i]) || isset($requested[$j])) {
            return false;
        } else {
            return true;
        }
    }


    /**
     * @param string $string String of the format: %PARAM_NAME%some_other_chars_maybe
     * @param mixed $name Variable which will
     * @return integer Position of the second '%' in the string
     * @throws Exception
     */
    private function parseParameterName($string, &$name)
    {
        $name = '';
        $i = 1;

        while ($string[$i] !== '%') {
            $name .= $string[$i];

            $i++;

            if (!isset($string[$i])) {
                throw new Exception("Bad route parameter configuration at \"{$string}\"");
            }
        }
        return ($i < strlen($string)) ? $i : false;
    }
}