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
     * @var int $status_code
     */
    private $status_code = 200;

    /**
     * @var string $view
     */
    private $view;

    public function setViewFile($viewFile, $path = "")
    {
        $this->view = "{$path}/{$viewFile}";
    }

    public function setStatusCode($status_code = 200)
    {
        $this->status_code = (int)$status_code;
    }

    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }

    public function releaseOutput($format)
    {
        // Set headers
        foreach ($this->headers as $name => $value) {
            header($name . ': ' . $value);
        }

        // Set status code
        http_response_code($this->status_code);

        // Engage output buffer
        ob_start();

        $attributes = $this->attributes();

        if (is_null($format) && is_string($attributes)) {
            echo $attributes;
        } elseif ($format === 'json') {
            // Set Content-Type
            header("Content-Type: application/json;charset=utf-8");

            echo json_encode([
                'body' => $attributes,
                'status' => ( (int) ($this->status_code / 100) !== 2) ? 'error' : 'success'
            ]);
        } else { // Expect a file
            if (!is_file("{$this->view}")) {
                throw new \Exception("Configuration error! The '{$format}' format expects a file! Check your configuration file for this route!");
            } else {
                $data = $attributes;

                require_once("{$this->view}");
            }
        }

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}