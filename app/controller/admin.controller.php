<?php

class admin{

    private $admin;

    public function __construct()
    {
        $this->admin = new admins();
    }

    private function checkAdmin($id){
        header("Content-Type: application/json");
        $user = $this->admin->get_user($id);
        if (!$user || $user['email'] !== 'dd@rr.com') {
            echo json_encode([
                "status" => "error",
                "errors" => ["login" => "Unauthorized user:We Go Find You👀👀"]
            ]);
             exit;
        }
    }

    public function dashboard(){
        $getStat = $this->admin->dashboard();
        View::views('admin/dashboard',[
            'getStat' => $getStat
        ]);
    }

    public function pendingStudent(){
        $pendingStudents = $this->admin->getPendingStudents();
        View::views('admin/pendingStudent',[
            'pendingStudents' => $pendingStudents,
        ]);
    }

        public function approveStudent(){
        $approvedStudents = $this->admin->getApprovedStudents();
        View::views('admin/approveStudent',[
            'approvedStudents' => $approvedStudents,
        ]);
    }

    public function approvedStudent(){
        header("Content-Type: application/json");
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $studentId = $_POST['student_id'] ?? null;
            if (!$studentId) {
                echo json_encode([
                    "status" => "error",
                    "msg" => "student ID is required"
                ]);
                exit;
            }

            $approved = $this->admin->approveReg($studentId);
            if($approved){
                echo json_encode([
                    "status" => "success",
                    "msg" => "student has been approved"
                ]);
            }else{
                echo json_encode([
                    "status" => "error",
                    "msg" => "failed to approve student"
                ]);
            }
            exit;
        }else{
            echo json_encode([
                "status" => "error",
                "errors" => [
                    "form" => "invalid request method"
                    ]
                ]);
        }
    }

    public function rejectStudent(){
        header("Content-Type: application/json");
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $studentId = $_POST['student_id'];
            if (!$studentId) {
                echo json_encode([
                    "status" => "error",
                    "msg" => "student ID is required"
                ]);
                exit;
            }

            $declined = $this->admin->declinedReg($studentId);
            if($declined){
                echo json_encode([
                    "status" => "success",
                    "msg" => "student has been approved"
                ]);
            }else{
                echo json_encode([
                    "status" => "error",
                    "msg" => "failed to approve student"
                ]);
            }
            exit;
        }else{
            echo json_encode([
                "status" => "error",
                "errors" => [
                    "form" => "invalid request method"
                    ]
                ]);
        }
    }   
    
    
    // public function logout(){
    //     Session::destroy();
    //     header("location: /final/login");
    // }
    
}