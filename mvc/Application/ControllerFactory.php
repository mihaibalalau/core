<?php

class ControllerFactory
{

    /**
     * ControllerFactory constructor.
     * @param Application $application
     * @param Request $request
     * @param Response $response
     * @throws HttpUrlException
     */
    public function __construct(Application $application, Request $request, Response $response)
    {

        if($route = $application->Configuration()->Routes()->getRouteByURI($request->Route()->getURI())) {
            $controllerClass = $route['controller'];

            if($controllerClass) {

                require_once("application/controllers/{$controllerClass}.php");

                new $controllerClass($application, $request, $response);
            }

        } else {

            http_response_code(404);
        }
    }
}