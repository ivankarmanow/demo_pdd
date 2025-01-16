<?php

require_once "Controller.php";
require_once "Model.php";


$routes = [
    "GET" => [
        "/" => "index",
        "/new_form" => "new_form",
        "/login_form" => "login_form",
        "/reg_form" => "reg_form",
        "/admin" => "admin",
        "/logout" => "logout"
    ],
    "POST" => [
        "/new" => "new",
        "/login" => "login",
        "/reg" => "reg",
        "/change_status" => "change_status"
    ]
];

$config = parse_ini_file("config.ini");
$model = new Model($config['dns']);
Controller::$db = $model;
Controller::$config = $config;
session_start();

if (isset($routes[$_SERVER['REQUEST_METHOD']][$_SERVER['REQUEST_URI']])) {
    [Controller::class, $routes[$_SERVER['REQUEST_METHOD']][$_SERVER['REQUEST_URI']]]();
} else {
    http_response_code(404);
}



