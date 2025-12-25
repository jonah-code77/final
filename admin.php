<?php
require("app/app.php");

$controller = new admin();

$url = $_GET['url'] ?? "dashboard";

if ($url === "dashboard") {
    $controller->dashboard();
    exit;
}elseif($url === "approvedStudent"){
    $controller->approvedStudent();
    exit;
}elseif($url === "rejectStudent"){
    $controller->rejectStudent();
}else{
    header("Content-Type: application/json");
    echo json_encode([
        "Status" => "error",
        "msg" => "Route Not Found"
    ]);
}


