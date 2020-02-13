<?php

class Routes {

    private $routes = [];

    public function __construct(SimpleXMLElement $routes) {

        $this->routes = xml_attributes($routes, 'url');
    }

    public function getRouteByURI($uri) {

        if(isset($this->routes[$uri])) {

            return $this->routes[$uri];

        } elseif(isset($this->routes["/{$uri}"])) {

            return $this->routes["/{$uri}"];

        } else {

            return null;
        }
    }
}