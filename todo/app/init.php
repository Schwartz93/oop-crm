<?php 

session_start();

$_SESSION['user_id'] = 1;

$db = new PDO('mysql:dbname=crm;host=127.0.0.1', 'root', 'root');

// HANDLE IN ANOTHER WAY
if(!isset($_SESSION['user_id'])) {
    die('You are not signed in');
}

?>