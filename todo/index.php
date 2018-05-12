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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    
    <link rel="stylesheet" href="../authentication/authentication_css/main.css">
    <link rel="stylesheet" href="css/main.css">
    <title>Polls</title>
</head>
<body onload="startTime()">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<p class="welcome">TO DO<a class="navbar-brand"></a></p>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="../authentication/index.php"><img src="../img/house.svg" width="30px" height="30px" alt="home_logo"><span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Features</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Pricing</a>
      </li>
    </ul>
    <span class="navbar-text">
        <a href="logout.php"><img width="60px" height="60px" src="../img/exit.svg" alt="logout_logo"></a>
    </span>
  </div>
</nav>

<div class="date">
  <div class="today"><?php echo "Date: " . date("d/m/Y") . "<br>"; ?></div>
</div>
<script>
function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('current_time').innerHTML =
    h + ":" + m + ":" + s;
    var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}
</script>
<div class="time">
  <div id="current_time"></div>
</div>
<body>

    <div class="list">
        <h1 class="header">To do</h1>
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
                    <a href="mark.php?as=delete&item=<?php echo $item['id']?>" class="delete-button">Delete this Task</a><br>
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
<footer>
    <div class="footer">
        <div>
            <p class="copyright">CRM 2018 - Michael Schwartz</p>
        </div>
    </div>
</footer>
  </body>
</html>