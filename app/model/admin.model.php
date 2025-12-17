<?php

class admin extends Dbh {

    //generate student code
    private function generateStudentCode($id){
        $prefix = "NIIT" . date('y');
        $padded = str_pad($id , 6 , "0" , STR_PAD_LEFT);
        return $prefix . $padded;
    }

    //approve student registration request
    public function approveReg($id){
        $studentId = $this->generateStudentCode($id);
        $sql = "UPDATE users SET reg_status = 'approved', student_code = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$studentId, $id]);
        return $studentId;
    }

    //reject student registration request
    public function declinedReg($id){
        $studentId = $this->generateStudentCode($id);
        $sql = "UPDATE users SET reg_status = 'declined', student_code = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$studentId, $id]);
    }

    //get pending student
    public function getPendingStudents(){
        $sql = "SELECT * FROM users WHERE reg_status = 'pending' ORDER BY ASC";
        $stmt = $this->conn->prepare($sql);
        return $stmt->fetchAll();
    }

    //get all approved students
    public function getApprovedStudents(){
        $sql = "SELECT * FROM users WHERE reg_status = 'approved' ORDER BY ASC";
        $stmt = $this->conn->prepare($sql);
        return $stmt->fetchAll();
    }

    //getStudentid
    public function getStudentId($id){
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}