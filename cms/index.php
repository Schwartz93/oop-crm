<?php 

require 'app/start.php';
// Daten für die index.php werden durch eine Query erhalten.
$pages = $db->query("
    SELECT id, label, slug
    FROM pages
")->fetchAll(PDO::FETCH_ASSOC);

require VIEW_ROOT . '/home.php';