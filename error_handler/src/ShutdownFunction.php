<?php

function myShutdownFunction() {
    $error = error_get_last();

    if( $error !== NULL) {
        $errno   = $error["type"];
        $errfile = $error["file"];
        $errline = $error["line"];
        $errstr  = $error["message"];

//        var_dump($errno);
        var_dump($errfile);
        die;
    }
}

register_shutdown_function("myShutdownFunction");