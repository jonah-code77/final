<?php
require "app/app.php";


$url = $_GET['url'] ?? 'login';


$segment = explode('/', trim($url,'/'));


$routes = require_once('routes.php');


$routeKey = count($segment) > 1 ? "{$segment[0]}/{$segment[1]}" : $segment[0];

$params = array_slice($segment,2);

if (isset($routes[$routeKey])) {
    
    [$controllerName, $methodName, $requiresAuth] = array_pad($routes[$routeKey], 3, false);

    if ($requiresAuth) {
        Session::exist();
    }

    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        if (method_exists($controller, $methodName)) {
            call_user_func_array([$controller, $methodName], $params);
        }else{
            header("Content-Type: application/json");
            echo json_encode([
                "Status" => "error",
                "msg" => "method <b>$method</b> doesn't exist in $controllerName"
            ]);
        
        }
    }else{
        header("Content-Type: application/json");
        echo json_encode([
            "Status" => "error",
            "msg" => "Controller '$controllerName' Not Found"
        ]);
    }
}else{
   header("Content-Type: application/json");
    echo json_encode([
        "Status" => "error",
        "msg" => "Route Not Found"
    ]);
}


