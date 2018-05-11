<?php 
// Connection wird eingebunden
require_once 'app/init.php';
// Die Fragen die innerhalb des in der DB bestimmten Zeitraums gültig sind werden als query gesetzt bzw ausgeführt und als objekt zurückgegeben in $pollsQuery
$pollsQuery = $db->query("
    SELECT id, question
    FROM polls
    WHERE DATE(NOW()) BETWEEN starts AND ends
");
// $row speichert das zurückgegebene Objekt in jeder reihe und gibt die werte in der while schleife an das $polls array zurück 
while($row = $pollsQuery->fetchObject()) {
    $polls[] = $row;
}
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
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="../authentication/authentication_css/main.css">
    <title>Polls</title>
</head>
<body onload="startTime()">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<p class="welcome">Polls<a class="navbar-brand"></a></p>
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
<!-- Solange das array nicht leer ist, wird mit einer foreach schleife durchlaufen und die array einträge in form von links ausgegeben. Die GET Parameter 
     werden mit der $poll->id und poll->question übergeben.-->
     <div class="container">
    <div class="subtitle">Latest polls</div>
    <?php if(!empty($polls)): ?>
        <ul>
        <div class="row">
            <?php foreach($polls as $poll): ?>
            <div class="col">
                        <img width="130px" height="130px" src="../img/elections.svg" alt="poll_logo">
                    <li>
                        <a class="poll_li" href="poll.php?poll=<?php echo $poll->id; ?>"><?php echo $poll->question; ?></a>
                    </li>
                    </div>
            <?php endforeach; ?>
            </div>
        </ul>
    <?php else: ?>
        <p>Sorry no polls available right now.</p>
    <?php endif; ?>
<footer>
    <div class="footer">
        <div>
            <p class="copyright">CRM 2018 - Michael Schwartz</p>
        </div>
    </div>
</footer>
  </body>
</html>