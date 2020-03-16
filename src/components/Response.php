<?php
namespace CORE\Components;
use CORE\AttributeHolder;

/**
 * Class Response
 * @package CORE
 * CORE [1/3]
 *
 */
final class Response extends AttributeHolder
{
    /**
     * @var array $headers
     */
    private $headers;

    /**
     * @var string $view
     */
    private $view;

    public function __construct($viewFile = "")
    {
        $this->view = $viewFile;
    }

    public function setView($viewFile)
    {
        $this->view = $viewFile;
    }

    public function releaseOutput($json = false)
    {
        ob_start();

        $data = json_encode($this->getAttributes());

        if (!is_file("{$this->view}.html")) {
            echo $data;

        } else {
            $data = json_decode($data, true);

            require_once("{$this->view}.html");
        }

        ob_end_flush();
    }
}