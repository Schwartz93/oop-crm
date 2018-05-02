<?php 
require_once 'core/init.php';

$user = new User();
// Ausführung der logout Methode (Siehe user.php!)
$user->logout();
// Redirect zur index.php
Redirect::to('index.php'); 