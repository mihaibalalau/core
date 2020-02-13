<?php

class Response extends AttributesFactory {

    /**
     * @var Output $output
     */
    private $output;

    //TODO
    private $headers;

    /**
     * @var string $view
     */
    private $view;

    public function __construct(Configuration $configuration) {

        $route = $configuration->Routes()->getRouteByURI($_SERVER['REQUEST_URI']);

        if(isset($route['method']) && $route['method'] !== $_SERVER['REQUEST_METHOD']) {

            http_response_code(400);
        }

        $this->output = new Output();

        $this->setView($configuration->Routes()->getRouteByURI($_SERVER['REQUEST_URI'])['view']);
    }

    public function setView($viewFile) {

        $this->view = $viewFile;
    }

    public function releaseOutput() {

        ob_start();

        /**
         * Prepare data for view injection
         */
        $data = json_decode(json_encode($this->getAttributes()), true);

        /**
         * Load view
         */
        $view = $this->getView();
        require_once("{$view}.html");


        /**
         * Load contents to the output stream
         */
        $this->Output()->write(ob_get_contents());

        ob_end_clean();


        /**
         * Release output
         */
        echo $this->Output()->get();
    }

    public function Output() {

        return $this->output;
    }

    public function getView() {

        return $this->view;
    }

}