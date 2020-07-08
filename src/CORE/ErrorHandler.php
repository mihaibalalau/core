<?php
namespace CORE;

class ErrorHandler
{
    public function __construct($file = '')
    {
        ini_set('display_errors', 0);

        if ( $file ) {

            $currentDir = getcwd();

            register_shutdown_function(function() use($file, $currentDir) {
                $error = error_get_last();

                if ( $error ) {
                    chdir($currentDir);

                    $r = file_put_contents($file, json_encode($error), FILE_APPEND);

                    echo("<h1>ERROR!</h1><br/> Check {$file} for more information!");
                }
            });
        } else {
            register_shutdown_function(function() {
                $error = error_get_last();

                if ( $error ) {
                    echo("<h1>ERROR!</h1><br/>");
                    echo($error['message']);
                }
            });
        }
    }
}