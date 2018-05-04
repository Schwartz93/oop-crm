<?php 
    require_once 'app/init.php';

    if(isset($_GET['as'], $_GET['item'])) {
        $as   = $_GET['as'];
        $item = $_GET['item'];

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

    header('Location: index.php');
?>