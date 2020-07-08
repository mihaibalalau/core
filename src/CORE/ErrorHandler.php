<?php
namespace CORE;

class ErrorHandler
{
    public function __construct($file = '')
    {
        ini_set('display_errors', 0);

        if ( $file ) {

            register_shutdown_function(function() use($file) {
                $error = error_get_last();

                $fh = fopen($file, "a+");

                fwrite($fh, json_encode($error));

                die("ERROR! Check {$file} for more information!");
            });
        } else {
            register_shutdown_function(function() {
                $error = error_get_last();

                echo("<h1>ERROR!</h1><br/>");
                echo($error['message']);
                die;
            });
        }
    }
}