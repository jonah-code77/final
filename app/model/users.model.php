<?php

class users extends Dbh {

    //reg student
    public function registerStudent($firsname,$lastname,$email,$gender,$password,$dept,$profile_pic){
        $sql = "INSERT INTO users (firstname, lastname, email, gender, password, dept, profile_picture) VALUES(? , ? , ? , ? , ? , ? , ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$firsname, $lastname, $email, $gender, $password, $dept, $profile_pic]);
        return $this->conn->lastInsertId();
    }

    //student exist
    public function studentExist($email){
        $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    //getStudentOwnedRecord
    public function getStudentOwnedRecord($id){
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    //login 
    public function logIn($Email,$password){
        $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$Email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password,$user['password'])) {
            return $user;
        }
        return false;    
    }
}