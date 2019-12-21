<?php

/**
 * Class ApplicationController
 *
 * Sets up main properties for the application, creates
 *      the infrastructure for the development process,
 *      minimal mvc logic.
 *
 */
class ApplicationController {

    public final function __construct($configurationFile) {

        /**
         * Load the configuration
         */
        Configuration::setXMLFilePath($configurationFile);

        $configuration = new Configuration();

        /**
         * Load framework modules
         */
        new ModuleLoader($configuration->getModules());

        /**
         * Load listeners
         */
        $listenerFactory = new ListenerFactory($configuration->getListeners()); 

        /**
         * Initialize application object and run its listeners
         */
        $application = new Application($configuration);

        $listenerFactory->engageApplicationListeners($application);

        /**
         * Initialize request object and run its listeners
         */
        $request = new Request();
        $listenerFactory->engageRequestListeners($application, $request);


        /**
         * Initialize response object
         */
        $response = new Response($configuration);


        /**
         * Init controller
         */
        try {

            new ControllerFactory($application, $request, $response);
        } catch (HttpUrlException $e) {

            header("HTTP/1.0 404 Not Found");
            echo $e->getMessage();
        }

        /**
         * Run response listeners
         */
        $listenerFactory->engageResponseListeners($application, $request, $response);

        $response->releaseOutput();

    }
}