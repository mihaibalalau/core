<?php
namespace CORE;

class ErrorHandler
{
    public function __construct($file = '')
    {
            register_shutdown_function(function() {
                $error = error_get_last();
                var_dump($error);
                die;
            });
    }
}