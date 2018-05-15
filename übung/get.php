<?php

$vorname = $_GET['vorname'];
$nachname = $_GET['nachname'];
echo "Hallo $vorname $nachname";
?>

<form action="" method="get">
    <input type="text" name="vorname" id="">
    <input type="text" name="nachname" id="">
    <input type="submit" value="Submit">
</form>