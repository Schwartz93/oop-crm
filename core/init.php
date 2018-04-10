<?php 
// SESSION START
    session_start();
// SET UP CONNECTION DETAILS FOR THE DATABASE
    $GLOBALS['config'] = array(
        'mysql' => array(
            'host' => '127.0.0.1',
            'username' => 'root',
            'password' => 'root',
            'db' => 'crm'
        ),
// SET UP "REMEMBER ME" DETAILS
        'remember' => array(
            'cookie_name' => 'hash',
            'cookie_expiry' => 604800
        ),
// SET UP SESSION DETAILS
        'session' => array(
            'session_name' => 'user'
        )
    );
// AUTOLOADING CLASSES. $ CLASS IS BEING SUBSTITUTED WITH WHATEVER CLASS IS IN USE
    spl_autoload_register(function($class) {
        require_once 'classes/' . $class . '.php';
    });

    require_once 'functions/sanitize.php';

?>