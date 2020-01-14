<?php
$d = [
    "application" => [
        "controllers",
        "listeners",
        "models",
        "views"
    ],
    "public" => [
        "css",
        "images",
        "js"
    ],
];

function build($arr, $path) {
    foreach ($arr as $key => $value) {

        $ret = null;
        $output = [];

        if (is_numeric($key)) {

            $command = "mkdir \"{$path}/{$value}\" 2>&1";
            exec($command, $output, $ret);

        } else if(is_array($value)){

            build($value, "{$path}/{$key}");
        }

    }
}


build($d, "..");

