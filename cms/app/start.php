<?php 
ini_set('display_errors', 'On');

// Diverse rootverzeichnise werden definiert. Magische Konstanten: __DIR__ -> Beim inkludieren wird das Verzechnis der Datei angegeben.
define('APP_ROOT', __DIR__);
define('VIEW_ROOT', APP_ROOT . '/views');
define('BASE_URL', 'http://localhost/oop-crm/cms');
// PDO Connection
$db = new PDO('mysql:host=127.0.0.1;dbname=crm', 'root', 'root');

require 'functions.php';

?>