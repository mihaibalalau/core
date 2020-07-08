<?php
namespace CORE\Parts;

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
        foreach ($routes as $route) {
            $this->matchCase = isset($route->match_case) ? $route->match_case : true;

            if (strpos($route->url, '%')) {
                $parameters = $this->try($route->url, $requestURI);

                if ($parameters) {
                    $this->parameters = $parameters;
                    $this->route = $route;
                    break;
                }
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

    private function try($known, $requested)
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
                                return $parameters ? : true;
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
     */
    private function parseParameterName($string, &$name)
    {
        $name = '';
        for ($i = 1; $string[$i] !== '%'; $i++ ) {
            $name .= $string[$i];
        }
        return ($i < strlen($string)) ? $i : false;
    }
}