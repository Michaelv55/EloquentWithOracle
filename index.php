<?php

include 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;
use Yajra\Oci8\Connectors\OracleConnector;
use Yajra\Oci8\Oci8Connection;

$capsule = new Capsule();

$manager = $capsule->getDatabaseManager();

$manager->extend('oracle', function ($config) {
    $connector = new OracleConnector();
    $connection = $connector->connect($config);
    $db = new Oci8Connection($connection, $config["database"], $config["prefix"]);
    // set oracle date format to match PHP's date
    $db->setDateFormat('YYYY-MM-DD HH24:MI:SS');
    return $db;
});
 
$capsule->addConnection([
    'driver'        => 'oracle',
    'tns'           => '',
    'host'          => '192.xxx.xxx.xx',
    'port'          => '1521',
    'database'      => 'DATABASE',
    'username'      => 'USERNAME',
    'password'      => 'PASSWORD',
    'charset'       => 'UTF8',
    'prefix'        => '',
    'prefix_schema' => ''
]);
$capsule->setAsGlobal();

$capsule->bootEloquent();

class UsersModel extends Model {
    protected $table = 'SCHEMA.USERS_TABLE';
}

dd((new UsersModel)->where('ID', '=', '1')->get());

// dd($capsule->table('GESTIONNEW.USUARIOS')->where('ID_USUARIO', '=', '1013692581')->get());

 
// // Set the event dispatcher used by Eloquent models... (optional)
// use Illuminate\Events\Dispatcher;
// use Illuminate\Container\Container;
// $capsule->setEventDispatcher(new Dispatcher(new Container));