<?php

include ('../../libs/Server.php');

$server = new Server();
$cars = $server->method();
/*$cars = $server->cars();
$cars_json = json_encode($cars);
echo $cars_json;*/