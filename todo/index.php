<?php 
// init.php wird eingebunden
require_once 'app/init.php';
// Spezifische Item Daten aus der DB holen bzw das SQL Statement vorbereiten.
$itemsQuery = $db->prepare("
    SELECT id, name, done
    FROM items_todo
    WHERE user = :user
");
// Die verwendete Session User id wird dem User in Zeile 8 zugeordnet und das SQL Statement ausgeführt.
$itemsQuery->execute([
    'user' => $_SESSION['user_id']
]);
// Das Ergebnis dieser Query wird mit rowCount auf die Anzahl an Ergebnissen geprüft. 
// Ist das Ergebnis von rowCount positiv wird $items mit $itemsQuery gleichgesetzt. Andernfalls wird ein leeres Array zurückgegeben.
$items = $itemsQuery->rowCount() ? $itemsQuery : [];


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="css/main.css">
    <title>Todo App</title>
</head>
<body>
    <div class="list">
        <h1 class="header">To do.</h1>
<!-- Prüfen ob $items einen Wert enthält. Falls ja wird eine Unordered List erstellt mit der Klasse items -->
        <?php if (!empty($items)): ?>
        <ul class="items">
<!-- Mit einer foreach Schleife wird das $items Array durchlaufen und die Einträge als $item zurückgegeben. -->
            <?php foreach($items as $item): ?>
                <li>
<!-- Innerhalb eines spans welches die Items ausgeben soll, wird geprüft ob $item['done'] einen wert enthält bzw gesetzt ist. 
     Falls ja wird der Klassenname um 'done' erweitert. Anernfalls wird ein leerstring zurückgegeben. -->
                    <span class="item<?php echo $item['done'] ? ' done' : '' ?>"> <?php echo $item['name']; ?></span>
<!-- Ist item nicht gleich 'done' wird ein link generiert welcher die option bietet das item als 'done' zu markieren -->
                        <?php if(!$item['done']): ?>
<!-- 'done','notdone' bzw. 'delete' werden per Click an $_GET übergeben und in mark.php mit einem switch case unterschieden. 
      Daraufhin wird die entsprechende Query als Array erstellt und ausgeführt.-->
                    <a href="mark.php?as=done&item=<?php echo $item['id']?>" class="done-button">Mark as done</a>
                        <?php elseif(!$item['notdone']): ?>
                    <a href="mark.php?as=notdone&item=<?php echo $item['id']?>" class="not-done-button">UNDO</a>
                    <a href="mark.php?as=delete&item=<?php echo $item['id']?>" class="delete-button">Delete this Task</a>
                        <?php endif; ?>
                </li>
            <?php endforeach; ?>
<!-- Ist kein Eintrag in der DB vorhanden wird der paragraph ausgegeben "ou haven't added any items yet" -->
        </ul>
        <?php else: ?>
            <p>You haven't added any items yet</p>
        <?php endif; ?>

        <form action="add.php" class="item-add"  method="post">
            <input type="text" name="name" placeholder="Type a new item here." class="input" autocomplete="off" required>
            <input type="submit" value="Add" class="submit">
        </form>
    </div>
</body> 
</html>