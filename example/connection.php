<?php

require_once '../vendor/autoload.php';

// $source     = new Nurmanhabib\WilayahIndonesia\Sources\ArraySource;
$source     = new Nurmanhabib\WilayahIndonesia\Sources\DatabaseSource;
$wilayah    = new Nurmanhabib\WilayahIndonesia\WilayahIndonesia($source);
