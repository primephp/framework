<?php

require_once '../vendor/autoload.php';

function generate_uuid() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

$a = new Prime\Util\Collection\ArrayObject();

$a->fill(0, 8, 'mixed');

var_dump($a);
foreach ($a as $value) {
    echo "$value <br>";
}