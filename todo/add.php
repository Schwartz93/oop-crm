<?php 
// DB Verbindung wird eingebunden
require_once 'app/init.php';
// Wenn $_POST des inputs 'name' einen Wert enthält wird dieser in $name gespeichert
if(isset($_POST['name'])) {
    $name = trim($_POST['name']);
// Enthält $name einen Wert, wird mit der PDO Funktion prepare() die DB Verbindung ausgeführt und ein SQL Statement vorbereitet und als Objekt an $addedQuery übergeben.
// :name bzw :user steht als Platzhalter
// 0 Steht für Ausstehend bzw NotDone.
    if(!empty($name)) {
        $addedQuery = $db->prepare("
            INSERT INTO items_todo (name, user, done, created)
            VALUES (:name, :user, 0, NOW())
        ");
// Mit execute() werden die Placeholder :name und :user mittels Array befüllt und das Statement ausgeführt.
        $addedQuery->execute([
            'name' => $name,
            'user' => $_SESSION['user_id']
        ]);
    }
}
// Anschließend wird per header Funktion sofort wieder an die index.php geleitet.
header('Location: index.php');
?>