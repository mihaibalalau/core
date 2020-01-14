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

        if (is_numeric($key) && !file_exists("{$path}/{$value}")) {

                mkdir("{$path}/{$value}");

        } else if(is_array($value)){

            if(!file_exists("{$path}/{$key}")) {

                mkdir("{$path}/{$key}");
            }

            build($value, "{$path}/{$key}");
        }
    }
}


build($d, "..");

