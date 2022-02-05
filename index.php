<?php
    
set_include_path("./src");
require_once("Router.php");
require_once("model/MenuStorage.php");
require_once("model/MenuStorageMySQL.php");
require_once("model/AccountStorageMySQL.php");
require_once("mysql_config.php");
// require_once("/users/NUMETU/private/mysql_config.php");

$router = new Router(new MenuStorageMySQL($MYSQL_DSN, $MYSQL_USER, $MYSQL_PASSWORD), new AccountStorageMySQL($MYSQL_DSN, $MYSQL_USER, $MYSQL_PASSWORD));
$router->main();

?>
