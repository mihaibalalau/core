<?php

class ListenerFactory {

    private $listeners = [];

    public function __construct(SimpleXMLElement $listeners) {

        foreach($listeners->listener as $listener) {

            $listenerClass = (string) $listener['name'];

            require_once("application/listeners/{$listenerClass}.php");

            $this->listeners[get_parent_class($listenerClass)][] = $listenerClass;
        }
    }

    public function engageApplicationListeners(Application $application) {

        if(!empty($this->listeners['ApplicationListener'])) {

            foreach($this->listeners['ApplicationListener'] as $applicationListeners) {

                new $applicationListeners($application);
            }
        }
    }

    public function engageRequestListeners(Application $application, Request $request) {

        if(!empty($this->listeners['RequestListener'])) {

            foreach ($this->listeners['RequestListener'] as $requestListener) {

                new $requestListener($application, $request);
            }
        }
    }

    public function engageResponseListeners(Application $application, Request $request, Response $response) {

        if(!empty($this->listeners['ResponseListener'])) {

            foreach ($this->listeners['ResponseListener'] as $responseListener) {

                new $responseListener($application, $request, $response);
            }
        }
    }
}