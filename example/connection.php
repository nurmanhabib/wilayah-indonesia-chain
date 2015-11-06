<?php

require_once '../vendor/autoload.php';

// $source     = new Nurmanhabib\WilayahIndonesia\Sources\ArraySource;
$source     = new Nurmanhabib\WilayahIndonesia\Sources\SampleSource;
$wilayah    = new Nurmanhabib\WilayahIndonesia\WilayahIndonesia($source);

// Optional connection DB
// use Illuminate\Database\Capsule\Manager as Capsule;

// $capsule = new Capsule;

// $capsule->addConnection([
//     'driver'    => 'mysql',
//     'host'      => 'localhost',
//     'database'  => 'database',
//     'username'  => 'root',
//     'password'  => 'password',
//     'charset'   => 'utf8',
//     'collation' => 'utf8_unicode_ci',
//     'prefix'    => '',
// ]);

// // Make this Capsule instance available globally via static methods... (optional)
// $capsule->setAsGlobal();

// // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
// $capsule->bootEloquent();

// // Set connection to Repository
// $wilayah->setConnection($capsule);
