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
    <link rel="stylesheet" href="css/main.css">
    <title>Polls</title>
</head>
<body>
<!-- Solange das array nicht leer ist, wird mit einer foreach schleife durchlaufen und die array einträge in form von links ausgegeben. Die GET Parameter 
     werden mit der $poll->id und poll->question übergeben.-->
    <?php if(!empty($polls)): ?>
        <ul>
            <?php foreach($polls as $poll): ?>
                <li><a href="poll.php?poll=<?php echo $poll->id; ?>"><?php echo $poll->question; ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Sorry no polls available right now.</p>
    <?php endif; ?>
</body>
</html>