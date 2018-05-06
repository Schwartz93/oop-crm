<?php 
require 'app/start.php';
// Eine Seite wird angezeigt falls GET befüllt ist.
if(empty($_GET['page'])) {
    $page = false;
} else {
    $slug = $_GET['page'];
// Mit Hilfe des slugs wird überprüft um welche Seite es sich handelt und diese entsprechend vorbereitet.
    $page = $db->prepare("
        SELECT *
        FROM pages
        WHERE slug = :slug
        LIMIT 1
    ");
// $page wird mit dem slug befüllt, ausgeführt..
    $page->execute(['slug' => $slug]);
//.. und als assoziatives array neu gespeichert.
    $page = $page->fetch(PDO::FETCH_ASSOC);
// Ist ein Wert vorhanden werden noch die Timestamps vom Erstellen und wenn geschehen, Editieren angezeigt.
    if($page) {
        $page['created'] = new DateTime($page['created']);

        if($page['updated']) {
            $page['updated'] = new DateTime($page['updated']);
        }
    }
}

require VIEW_ROOT . '/page/show.php';