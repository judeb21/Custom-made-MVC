<?php
    // Load config.php file
    require_once "config/config.php";
    // Load Helpers
    require_once "helpers/url_helper.php";
    require_once "helpers/session_helper.php";

    // An autoloader to load core libraries
    spl_autoload_register(function($className){
      require_once "libraries/$className.php";
    });
?>
