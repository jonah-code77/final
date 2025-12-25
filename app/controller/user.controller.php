<?php
class user{
    private $users;

    public function __construct()
    {
        $this->users = new users();
    }

    //load registerform view
    public function regForm(){
        View::views("register");
    }
    public function regStud(){
        $msg = "student";
        View::views("register", ['msg' => $msg]);
    }

    //regForm Ajax
    public function regStudent(){
        header("Content-Type: application/json");
        $errors = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $firstname = isset($_POST['firstname']) ? trim($_POST['firstname']) : "";
            $lastname = isset($_POST['lastname']) ? trim($_POST['lastname']) : "";
            $gender = isset($_POST['gender']) ? trim($_POST['gender']) : "";
            $email = isset($_POST['email']) ? trim($_POST['email']) : "";
            $dept = isset($_POST['dept']) ? trim($_POST['dept']) : "";
            $password = isset($_POST['password']) ? trim($_POST['password']) : "";
            $profile_picture = $_FILES['img'];

            //registraion
            $err = Validator::required($firstname, "First Name is required ");
            if($err) $errors["firstname"] = $err;

            $err = Validator::required($lastname, "Last Name is required ");
            if($err) $errors["lastname"] = $err;
   
            $err = Validator::required($password, "password is required ");
            if($err) $errors["password"] = $err;

            $err = Validator::required($dept, "please input a department ");
            if($err) $errors["dept"] = $err;
            
            $err = validator::required($email, "Email is required ");
            if($err) $errors["email"] = $err;

            $err = validator::email($email);
            if($err) $errors["email"] = $err;

            $err = validator::required($gender, "gender is required ");
            if($err) $errors["gender"] = $err;

            $err = validator::gender($gender);
            if($err) $errors["gender"] = $err;

            if($email && $this->users->studentExist($email)) $errors["email"] = "Email already registered";

            //images         
            $err = Validator::image($profile_picture);
            if($err) $errors['img'] = $err;

            if (!empty($errors)) {
                echo json_encode([
                    "status" => "error",
                    "errors" => $errors
                ]);
                exit;
            }

            $ext = strtolower(pathinfo($profile_picture['name'], PATHINFO_EXTENSION));
            $filename = uniqid("IMG_") . "." . $ext;
            $uploadDir = "upload/user/";

            if(!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $uploadPath =$uploadDir. $filename;

            if(!move_uploaded_file($profile_picture['tmp_name'], $uploadPath)){
                echo json_encode([
                    "status" => "error",
                    "errors" => ['img' => 'failed to upload']
                ]);
            }
        
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $regStudent = $this->users->registerStudent($firstname, $lastname, $email, $gender, $hashed_password, $dept, $uploadPath);
            
            if(!$regStudent){
                echo json_encode([
                "status" => "error",
                "errors" => ["database" => "failed to register"]               
                ]);
                exit;
            }else{

            //success redirection    
            echo json_encode([
                "status" => "success",
                
                "redirect" => "/FINAL/home"
            ]);
            exit;
        }
    }else{
        echo json_encode([
            "status" => "error",
            "errors" => [
                "form" => "invalid request method"
                ]
            ]);
        }
    }

    public function home(){
        View::views("home");
    }

    public function login(){
        View::views("login");
    }

    public function logInn(){
        header("Content-Type: application/json");
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = isset($_POST['email']) ? trim($_POST['email']) : "";
            $password = isset($_POST['password']) ? trim($_POST['password']) : "";

            $err = Validator::required($email, "email is required");
            if($err) $errors['email'] = $err;

            $err = Validator::email($email);
            if($err) $errors['email'] = $err;

            $err = Validator::required($password, "password is required");
            if($err) $errors['password'] = $err;
                                    
            if (!empty($errors)) {
                    echo json_encode([
                        "status" => "error",
                        "errors" => $errors
                    ]);
                    exit;
            }

            $user = $this->users->logIn($email,$password);

            if($user){
                    Session::setSession('email',$user['email']);
                    Session::setSession('user_id',$user['id']);
                      //success redirection 
                      
                if($user['email'] === "dd@rr.com"){
                    $redirect = "/final/admin/dashboard";
                }else{
                    $redirect = "/final/home";
                }
                echo json_encode([
                    "status" => "success",                 
                    "redirect" => $redirect
                ]);
                exit;
                    
                }else{
                    echo json_encode([
                        "status" => "error",
                        "errors" => ["login" => "invalid Details"]
                    ]);
                    exit;
            }

        }
    }

}

