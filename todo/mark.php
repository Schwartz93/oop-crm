<?php 
// init.php einbinden
require_once 'app/init.php';
// Ist in der URL (GET) sowohl 'as' als auch 'item' vorhanden werden entsprechende Variablen damit befüllt
    if(isset($_GET['as'], $_GET['item'])) {
        $as   = $_GET['as'];
        $item = $_GET['item'];
// Mit switch cas auf die Werte überprüfen. Je nach GET Werten 'done', 'notdone' oder 'delete', werden verschiedene Queries vorbereitet und ausgeführt.
        switch ($as) {
            case 'done':
                $doneQuery = $db->prepare("
                    UPDATE items_todo
                    SET done = 1
                    WHERE id = :item
                    AND user = :user
                ");

                $doneQuery->execute([
                    'item' => $item,
                    'user' => $_SESSION['user_id']
                ]);
                break;

            case 'notdone':
                $doneQuery = $db->prepare("
                    UPDATE items_todo
                    SET done = 0
                    WHERE id = :item
                    AND user = :user
                ");
                
                $doneQuery->execute([
                    'item' => $item,
                    'user' => $_SESSION['user_id']
                ]);
                break;

            case 'delete':
                $doneQuery = $db->prepare("
                    DELETE from items_todo
                    WHERE id = :item
                    AND user = :user
                ");

                $doneQuery->execute([
                    'item' => $item,
                    'user' => $_SESSION['user_id']
                ]);
                break;

        }
    }
// Anschließend wird wieder auf die index.php geleitet.
    header('Location: index.php');
?>