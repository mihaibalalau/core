<?php
namespace CORE\Components;
use CORE\AttributeHolder;
use CORE\ErrorHandler;

/**
 * Class Application
 * @package CORE
 * CORE [1/3]
 *
 */
final class Application extends AttributeHolder
{
    private $config;
    private $environment;

    public function __construct($config_file)
    {
        $this->config = json_decode(file_get_contents($config_file));

        if (!is_null($this->config->error_log_file)) {
            new ErrorHandler($this->config->error_log_file);
        }

        $this->environment = getenv("ENVIRONMENT") ? : "dev";
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getEnvironment()
    {
        return $this->environment;
    }
}