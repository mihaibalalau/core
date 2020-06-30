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

    public function setView($viewFile, $path = "")
    {
        $this->view = "{$path}/{$viewFile}";
    }

    public function releaseOutput($json = false)
    {
        ob_start();

        $data = json_encode($this->attributes());

        if (!is_file("{$this->view}")) {
            echo $data;

        } else {
            $data = json_decode($data, true);

            require_once("{$this->view}.html");
        }

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}