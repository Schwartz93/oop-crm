<?php

require '../app/start.php';
// Siehe add.php
if(!empty($_POST)) {
    $id    = $_POST['id'];
    $label = $_POST['label'];
    $title = $_POST['title'];
    $slug  = $_POST['slug'];
    $body  = $_POST['body'];

    $updatePage = $db->prepare("
        UPDATE pages
        SET
            label   = :label,
            title   = :title,
            slug    = :slug,
            body    = :body,
            updated = NOW()
        WHERE id = :id
    ");

    $updatePage->execute([
        'id'    => $id,
        'label' => $label,
        'title' => $title,
        'slug'  => $slug,
        'body'  => $body
    ]);

    header('Location: ' . BASE_URL . 'admin/list.php');
}
// Ist die id nicht in der URL vorhanden -> Redirect.
if(!isset($_GET['id'])) {
    header('Location: ' . BASE_URL . 'admin/list.php');
    die();
}
// SQL Statement Vorbereiten 
$page = $db->prepare("
    SELECT id, title, label, body, slug
    FROM pages
    WHERE id = :id
");
// Entsprechend der Page-id ausführen
$page->execute(['id' => $_GET['id']]);
// Das erhaltene array mit PDO::FETCH_ASSOC als assoziatives Array zurückgeben und in $page speichern. 
$page = $page->fetch(PDO::FETCH_ASSOC);

require VIEW_ROOT . '/admin/edit.php';