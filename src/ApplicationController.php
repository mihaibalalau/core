<?php
namespace CORE;

/**
 * Class ApplicationController
 * @package CORE
 *
 * Creates a minimal MVC framework.
 * Requires a json configuration file and a file structure.
 *
 * Provides 3 tools for development
 *
 * [1/3] Application
 *      - holds app's configuration
 *      - provides an AttributesHolder to move data around without exposing it to the view
 * [2/3] Request
 *      - a wrapper for accessing the $_GET, $_POST and $_SERVER superglobals
 *
 * [3/3] Response
 *      - handles the response data, format and response stream
 *
 * Development after each of the above object has been initialized is allowed through the use
 *      of listeners - extend one of the 3 listeners ( ApplicationListener, RequestListener, ResponseListener )
 * Listeners are executed every time a request is received.
 * Listeners are executed in the order they are set in the configuration file
 * The controller is executed between the RequestListener and the ResponseListener, hence enabling you to alter
 *      the response before it's released to the user
 */
class ApplicationController
{
    public final function __construct(string $config_file)
    {
        $Application = new Components\Application($config_file);

        $Listeners = new Parts\Listeners($Application->getConfig()->listeners, $Application->getConfig()->listeners_path);

        $Listeners->engageApplicationListeners($Application);

        $Request = new Components\Request();

        $Listeners->engageRequestListeners($Application, $Request);

        $router = new Parts\Router($Application->getConfig()->routes, $Request->requestInfo("REDIRECT_URL"));

        $route = $router->getRoute();

        $Response = new Components\Response();
        $Response->setView(isset($route->view) ? $route->view : null, $Application->getConfig()->views_path);

        if (isset($route->controller)) {
            $controller_name = $route->controller;

            if (($p = strrpos($route->controller, "/")) !== false) {
                $controller_name = substr($route->controller, $p + 1);
            }

            require_once("{$Application->getConfig()->controllers_path}/{$route->controller}.php");
            (new $controller_name($Application, $Request, $Response))->run();
        }

        $Listeners->engageResponseListeners($Application, $Request, $Response);

        $Response->releaseOutput();
    }
}
