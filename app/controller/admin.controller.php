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
        $pendingStudents = $this->admin->getPendingStudents();
        $approvedStudents = $this->admin->getApprovedStudents();
        View::views('admin/dashboard',[
            'pendingStudents' => $pendingStudents,
            'approvedStudents' => $approvedStudents
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
    
    
}