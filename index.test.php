<?php
require("app/app.php");

$url = $_GET['url'] ?? 'login';
$segment = explode('/', trim($url,'/')); 
$controllerName = $segment[0] ?? "user";
$method = $segment[1] ?? 'login';
$parama = array_slice($segment, 2);

$publicRoutes = ['users' => ['login', 'register']];
if(!isset($publicRoutes[$controllerName])){
    !in_array($method, $publicRoutes[$controllerName]);

}else{
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
        "msg" => "method <b>$methodname</b> doesn't exist in $controllerName"
    ]);
            
        }
    }else{
            header("Content-Type: application/json");
        echo json_encode([
        "Status" => "error",
        "msg" => "class Not Found"
    ]);
    }

 
require("app/app.php");

$controller = new user();

$url = $_GET['url'] ?? "register";

if ($url === "register") {
    $controller->regForm();
    exit;
}elseif($url === "home"){
    Session::exist();
    $controller->home();
    exit;
}elseif($url === 'regStudent'){
    $controller->regStudent();
    exit;
}elseif($url === "login"){
    $controller->login();
}elseif($url === "logInn"){
    $controller->logInn();
}else{
    header("Content-Type: application/json");
    echo json_encode([
        "Status" => "error",
        "msg" => "Route Not Found"
    ]);
}





require("app/app.php");

$url = $_GET['url'] ?? 'user/login';
$segment = explode('/', trim($url, '/'));

$controllerKey = strtolower($segment[0] ?? 'user');
$method = $segment[1] ?? 'login';
$params = array_slice($segment, 2);

$controllerMap = [
    'user'  => 'User',
    'admin' => 'Admin'
];

$publicControllers = ['user'];

if (!in_array($controllerKey, $publicControllers)) {
    Session::exist();
}

if (!isset($controllerMap[$controllerKey])) {
    http_response_code(404);
    exit("Controller not found");
}

$controller = new $controllerMap[$controllerKey]();

if (!method_exists($controller, $method)) {
    http_response_code(404);
    exit("Method not found");
}

call_user_func_array([$controller, $method], $params);


require("app/app.php");

$controller = new admin();

$url = $_GET['url'] ?? "dashboard";

if ($url === "dashboard") {
    Session::exist();
    $controller->dashboard();
    exit;
}elseif($url === "approvedStudent"){
    $controller->approvedStudent();
    exit;
}elseif($url === "rejectStudent"){
    $controller->rejectStudent();
}elseif($url === "pendingStudent"){
    $controller->pendingStudent();
}elseif($url === "approveStudent"){
    $controller->approveStudent();
}else{
    header("Content-Type: application/json");
    echo json_encode([
        "Status" => "error",
        "msg" => "Route Not Found"
    ]);
}


