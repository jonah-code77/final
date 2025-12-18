<?php
require("app/app.php");

$controller = new user();

$url = $_GET['url'] ?? "register";

if ($url === "register") {
    $controller->regForm();
    exit;
}elseif($url === "home"){
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
