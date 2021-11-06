<?php

date_default_timezone_set("Asia/Shanghai");
if(@$_REQUEST['meshow']) phpinfo();


// If you installed via composer, just use this code to require autoloader on the top of your projects.
// require 'vendor/autoload.php';


// Imporrt and using Medoo namespace
// require './library/Medoo.php';
// use Medoo\Medoo;


class DBCONFIG {
	const CONF = [
		// required
		'database_type' => 'mysql',
		'database_name' => 'moviedata',
	 	'server' => '152.136.245.47',
		'username' => 'root',
		'password' => 'Xueting249!',

		// [optional]
		'charset' => 'utf8',
		'collation' => 'utf8_general_ci',
		'port' => 3306,

		// [optional] Table prefix
		'prefix' => '',

		// [optional] Enable logging (Logging is disabled by default for better performance)
		'logging' => true,

		// [optional] MySQL socket (shouldn't be used with server and port)
		// 'socket' => '/tmp/mysql.sock',

		// [optional] driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
		'option' => [
			PDO::ATTR_CASE => PDO::CASE_NATURAL
		],

		// [optional] Medoo will execute those commands after connected to the database for initialization
		'command' => [
			'SET SQL_MODE=ANSI_QUOTES'
		]
	];
}
// $db = new Medoo(DBCONFIG::CONF);
// $rows = $db->select("users", "name");
// $rows = $db->select("users", ["name", "role", "timestamp"]);


// $db->insert("account", [
// 	"user_name" => "foo",
// 	"email" => "foo@bar.com"
// ]);


define("APP_PATH",  realpath(dirname(__FILE__) )); /* 指向public的上一级 */


$app = new Yaf_Application(APP_PATH . "\conf\application.ini");

// $router = Yaf_Dispatcher::getInstance()->getRouter();
// $route = new Yaf_Route_Simple("m", "c", "a");
// $router->addRoute("name", $route);
// $router->addConfig(Yaf_Registry::get("config")->routes);

// $app->bootstrap()->run();
$app->run();
// $app->getDispatcher()->dispatch(new Yaf_Request_Simple());


