<?php 

$username = $_POST['username'];
$password = $_POST['password'];

echo "Das ist dein Username: " . $username . "<br>";
echo "Das ist dein Passwort: " . $password;

?>

<form action="" method="post">
    <input type="text" name="username" id="">
    <input type="password" name="password" id="">

    <input type="submit" value="Submit">
</form>