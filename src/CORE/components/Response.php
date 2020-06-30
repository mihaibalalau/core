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
    private $headers = [];

    /**
     * @var string $view
     */
    private $view;
    private $output = '';

    public function setViewFile($viewFile, $path = "")
    {
        $this->view = "{$path}/{$viewFile}";
    }

    public function setOutput($output)
    {
        $this->output = $output;
    }

    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }

    public function releaseOutput($json = false)
    {
        foreach( $this->headers as $name => $value ) {
            header($name . ': ' . $value);
        }

        if ( $this->output ) {
            return $this->output;
        }

        ob_start();

        if (!is_file("{$this->view}")) {
            $data = json_encode($this->attributes());

            echo $data;

        } else {
            $data = $this->attributes();

            require_once("{$this->view}");
        }

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}