<?php


//BASE URL 
DEFINE('BASE_URL', '/FINAL');
//BASE PATH SO I CAN GET ABSOLUTE PATH AT ANY POINT
DEFINE("BASE_PATH",__DIR__."/../");
//Autoload Files
spl_autoload_register(function($class){ 
    //paths
    $paths = [ 'app/config/', 'app/controller/', 'app/model/', 'app/core/'];

    //files extentions
    $exts = ['.php', '.controller.php', '.model.php', '.core.php'];

    //loop through to get our path
    foreach($paths as $path){
        //loop through to get our extension
        foreach($exts as $ext){
            $fullPath = $path . strtolower($class) . $ext;
            if (file_exists($fullPath)) {
                try {
                    require_once $fullPath;
                    return;
                } catch (\Throwable $e) {
                    die("error loading class '$class' from file '$file':" . $e->getMessage());
                }
            }
        }
    }
    throw new Exception("Autoload Error: Class '{$class}' not found. Checked paths: " . implode(', ', $paths));
});

// Session::start();