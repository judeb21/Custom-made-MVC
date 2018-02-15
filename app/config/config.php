<?php
    // DB PARAMETERS | PARAMETERS THAT COULD CHANGE IF WE CHANGE DBS OR DOMAINS
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASSWORD", "");
    define("DB_NAME", "postr"); // for testing purposes
    // APP ROOT
    define("APPROOT", dirname(dirname(__FILE__)));
    // URL ROOT | important for our links in views
    define("URLROOT", "http://localhost/PostR");
    // SITE NAME
    define("SITENAME", "PostR");
    // APP VERSION
    define("APPVERSION", "1.0.0");
 ?>
