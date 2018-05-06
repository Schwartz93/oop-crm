<?php 

require '../app/start.php';
// Holt die Daten aller verfügbaren pages um sie dann in /views/list.php auszugeben
$pages = $db->query("
    SELECT id, label, title, slug
    FROM pages
    ORDER BY created DESC
")->fetchAll(PDO::FETCH_ASSOC);

require VIEW_ROOT . '/admin/list.php';