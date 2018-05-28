<?php 
// Session wird gestartet
session_start();
// FIXE SESSION ID! ANBINDEN AN DIE USERS TABLE
$_SESSION['user_id'] = 1;
// PDO Conn wird auf $db zugewiesen
$db = new PDO('mysql:dbname=crm;host=127.0.0.1', 'root', 'root');

// SIEHE ZEILE 4
if(!isset($_SESSION['user_id'])) {
    die('You are not signed in');
}

?>