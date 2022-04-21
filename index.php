<?php

use Binarycaster\Binarysms\Binarysms;
use Binarycaster\Binarysms\Config;

require_once "vendor/autoload.php";

$a = new Binarysms(new Config);
$resp = $a->sayHello("John");

var_dump($resp);