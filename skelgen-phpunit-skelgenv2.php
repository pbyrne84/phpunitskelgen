<?php

use JESkelgen\Config\ItjbSkelgenConfig;


require_once __DIR__ . '/lib/Skelgen/Autoload/SkelgenAutoload.php';

$skelgenAutoload = new \Skelgen\Autoload\SkelgenAutoload();
$skelgenAutoload->initSkelgenAutoLoad();

$JESkelgenBoot = new \JESkelgen\JESkelgenBoot();
$JESkelgenBoot->bootAndRun();