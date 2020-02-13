<?php

function xml_attributes(SimpleXMLElement $element, $uniqueKey) {

    $res = [];

    foreach($element->children() as $key => $value) {

        $r = [];

        foreach($value->attributes() as $k => $v) {

            $r[$k] = (string) $v;
        }

        $res[$r[$uniqueKey]] = $r;
    }

    return $res;
}