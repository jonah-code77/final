<?php


class Session {

    //check if sessin is started already, if not it start a new session;
    public static function start(){
        if (session_status() === PHP_SESSION_NONE) {
            session_name('final');
            session_start();
        }
    } 

    //Gets the key of a session after which it set it equal to the value
    public static function setSession($key,$value){
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function getSession($key){
        self::start();
        return $_SESSION[$key] ?? null;
    }

    public static function getAll(){
        self::start();
        return $_SESSION;
    }

    public static function exist(){
        self::start();
        if(!isset($_SESSION['email']) ){
            header('location: /final/login');
            exit;
        };
    }

    public static function destroy(){
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }
    }

}