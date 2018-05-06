<?php 

require '../app/start.php';
// Wenn die id in der URL befüllt ist wird eine Query vorbereitet um die Einträge mit dieser id zu entfernen.
if(isset($_GET['id'])) {
    $deletePage = $db->prepare("
        DELETE FROM pages
        WHERE id = :id
    ");
// Query wird mit dem in den Platzhalter eingesetzten id Wert befüllt und ausgeführt.
    $deletePage->execute(['id' => $_GET['id']]);
}
// Weiterleiten zu list.php
header('Location: ' . BASE_URL . '/admin/list.php');