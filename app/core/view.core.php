<?php

class View {
    protected static $url;
    public static function views($url,$data = []){
        extract($data);
        self::$url = $url;
        $file = __DIR__ . ("/../view/$url.view.php");
        if (file_exists($file)) {
            require $file;
        }else{
            die("file not found: $url");
        }
    }
}