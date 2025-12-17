<?php
header("Content-Type: application/json");
$username = $_POST['username'];
$email = $_POST['email'];

if ($username === 'john' && $email === 'jonahosok@gmail.com') {
    echo json_encode([
        "status" => "success",
        "msg" => "login"
    ]);
}else{
    echo json_encode([
        "status" => "error",
        "msg" => "failed"
    ]);
}