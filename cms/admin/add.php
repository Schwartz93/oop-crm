<?php
require '../app/start.php';
// Die in den Formularfeldern eingegebenen POST Daten werden in entsprechende variablen gespeichert.
if(!empty($_POST)) {
    $label = $_POST['label'];
    $title = $_POST['title'];
    $slug  = $_POST['slug'];
    $body  = $_POST['body'];
// Mit dem PDO Objekt $db und der Methode prepare werden die DB Felder mit den oben gespeicherten Werten befüllt bzw vorbereitet. 
// (Aktuell noch mit Platzhaltern zb: :label)
    $insertPage = $db->prepare("
        INSERT INTO pages (label, title, slug, body, created)
        VALUES (:label, :title, :slug, :body, NOW())
    ");
// Ausführen der Query und einsetzen der zuvor gespeicherten Werte in den Platzhaltern
    $insertPage->execute([
        'label' => $label,
        'title' => $title,
        'slug'  => $slug,
        'body'  => $body
    ]);
// Nach dem Ausführen der Query wird mittels header() zur list.php weitergeleitet.
    header('Location: ' . BASE_URL . 'admin/list.php');
}


require VIEW_ROOT . '/admin/add.php';