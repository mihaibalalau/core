<?php

class ModuleLoader {

    public function __construct(SimpleXMLElement $modules) {

        foreach($modules->module as $module) {
            $moduleName = $module['name'];

            require_once("core/{$moduleName}/loader.php");
        }
    }

}