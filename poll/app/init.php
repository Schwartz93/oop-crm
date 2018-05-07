<?php

session_start();
// Fixe Sesseion id wird mit login verknüpft!!!!
$_SESSION['user_id'] = 1;
// Neues PDO Objekt bzw neue Connection
$db = new PDO('mysql:host=127.0.0.1;dbname=crm', 'root', 'root');

