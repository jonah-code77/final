<?php

class Validator{
    //required validation
    public static function required($value, $msg){
        if (trim($value) === "") {
            return $msg;
        }
        return null;
    }

    //email validation
    public static function email($value){
        if ($value === "") {
            return null;
        }

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return "invalid Email format";
        }

        return null;
    }

    //gender validation
    public static function gender($value){
        if ($value === "") {
            return null;
        }
        if(!in_array($value, ['male', 'female'])){
            return "invalid Gender";
        }
        return null;
    }

    //image validation
    public static function image($file, $maxsize = 3){
        if (!isset($file)) {
            return "profile picture is required";
        }

        if ($file['error'] !== UPLOAD_ERR_NO_FILE) {
            return "profile picture is required";
        }
        if($file['error'] !== UPLOAD_ERR_OK){
            return "file upload failed";
        }

        if(!@getimagesize($file['tmp_name'])){
            return "invalid image file";
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        $allowedMine = [
            'image/jpeg',
            'image/jpg',
            'image/png',
            'image/gif'
        ];

        if (!in_array($mime , $allowedMine)) {
            return "invalid image file";
        }

        $allowed_ext = [
            'jpg', 
            'jpeg', 
            'png', 
            'gif'
        ];
        $ext = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed_ext)) {
            return "invalid image type only JPG,JPEG,PNG AND GIF is allowed";
        }

        if($file['size'] > ($maxsize * 1024 * 1024)){
            return "image size exceed {$maxsize}mb";
        }

        return null;
    }
}