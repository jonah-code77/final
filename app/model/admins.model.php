<?php

class admins extends Dbh {

    //generate student code
    private function generateStudentCode(){
        $this->conn->exec("INSERT INTO studentid VALUES()");
        $id = $this->conn->lastInsertId();
        $prefix = "NIIT" . date('y');
        $padded = str_pad((int)$id , 4 , "0" , STR_PAD_LEFT);
        return $prefix . $padded;
    }

    //approve student registration request
    public function approveReg($id){
        $studentId = $this->generateStudentCode();
        $sql = "UPDATE users SET reg_status = 'approved', student_code = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$studentId, $id]);
    }

    //reject student registration request
    public function declinedReg($id){
        $sql = "UPDATE users SET reg_status = 'declined' WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

    //get pending student
    public function getPendingStudents(){
        $sql = "SELECT * FROM users WHERE reg_status = 'pending' ORDER BY id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    //get all approved students
    public function getApprovedStudents(){
        $sql = "SELECT * FROM users WHERE reg_status = 'approved' ORDER BY id ASC";
        $stmt = $this->conn->prepare($sql);
        return $stmt->fetchAll();
    }

    //getStudentid
    public function get_user($id){
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}