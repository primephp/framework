<?php

require_once '../vendor/autoload.php';

function generate_uuid() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

function cube($n) {
    return($n * $n * $n);
}

$a = array(1, 2,' 3', 4, 5);
$a = new Prime\Util\Collection\ArrayObject('integer', $a);
$a->add(1);
$a->add(2);
$a->add(3);
$a->add(4);
$a->add(5);


var_dump($a);
