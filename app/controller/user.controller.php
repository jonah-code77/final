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
            //$profile_picture = $_FILES['image'];

            //registraion
            if(empty($firstname)) $errors["firstname"] = "First Name is required";
            if(empty($lastname)) $errors["lastname"] = "Last Name is required"; 
            if(empty($password))  $errors["password"] =  "Password is required"; 
            if(empty($dept))  $errors["dept"] = "dept is required";

            if(empty($email)){
                 $errors["email"] = "email is required";
            }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                
                $errors["email"] = "invalid email format";
            }

            if(empty($gender)){
                 $errors["gender"] = "Gender is required";
            }elseif(!in_array($gender, ['male', 'female'])){
                
                $errors["gender"] = "Gender is invalid";
            }

            if($this->users->studentExist($email)) $errors["email"] = "Email already registered";

            //images
            if(!isset($_FILES['img'])){
                $errors["img"] = "please upload a profile picture";
            }else{
                    $profile_picture = $_FILES['img'];
                    if ($profile_picture['error'] === UPLOAD_ERR_NO_FILE) {
                        $errors["img"] = "please upload a profile picture";
                    }elseif($profile_picture['error'] !== UPLOAD_ERR_OK){
                        $errors["img"] = "file not uploaded";
                    }else{
                    //minme validation
                        $finfo = new finfo(FILEINFO_MIME_TYPE);
                        $mime = $finfo->file($profile_picture['tmp_name']);
                        $allowed_mimeType = ["image/jpeg", "image/png", "image/jpg", "image/gif"];

                        if(!in_array($mime, $allowed_mimeType)) $errors["img"] = "invalid image type uploaded";

                        //extention validation
                        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
                        $ext = strtolower(pathinfo($profile_picture['name'],PATHINFO_EXTENSION));
                        if(!in_array($ext, $allowed_ext)) $errors["img"] = "invalid image type uploaded";

                        // $imageInfo = getimagesize($profile_picture["tmp_name"]);
                        if (!@getimagesize($profile_picture['tmp_name'])) {
                            $errors['img'] = "invalid image formaty";
                        }

                        //size validation
                        if($profile_picture['size'] > 3 * 1024 * 1024) $errors["img"] =  "image size exceed 3mb";
                }
                        
                if (!empty($errors)) {
                    echo json_encode([
                        "status" => "error",
                        "errors" => $errors
                    ]);
                    exit;
                }
                //unique name
                $filename = uniqid("IMG_") . "." . "$ext";
                $uploadPath = "upload/user/" . $filename;

                if(!move_uploaded_file($profile_picture['tmp_name'], $uploadPath)){
                    echo json_encode([
                        "status" => "error",
                        "errors" => ["img" => "failed to upload"]
                    ]);
                    exit;
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

}

