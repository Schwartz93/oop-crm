<?php 
    require_once 'core/init.php';

  // Ausgabe der flash message wenn die Session existiert.
   if(Session::exists('home')) {
        echo '<p>' . Session::flash('home') . '</p>';
   }
  
  $user = new User(); 
  // Ist der User eingelogged wird sein Name ausgegeben. Sowie die Möglichkeit zum Ausloggen, Ändern der eignene Daten bzw Ändern des Passworts.
  if($user->isLoggedIn()) {
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
    <link rel="stylesheet" href="main.css">
    
    <title>Hallo</title>
  </head>
  <body>
    <p>Hello <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->username); ?></a>!</p>

      <ul>
          <li><a href="logout.php">Log out</a></li>
          <li><a href="update.php">Update Details</a></li>
          <li><a href="changepassword.php">Change Password</a></li>
          <li><a href="todo/index.php">Todo App</a></li>
          <li><a href="cms/admin/list.php">CMS/Blog</a></li>
          <li><a href="poll/index.php">Polls</a></li>
          <li><a href="timetracking/index.php">Timetracker</a></li>
      </ul>

<?php
// Ist der User nicht eingelogged, bekommt er die Möglichkeit dazu. Auch ein link zum registrieren wird angezeigt.
} else {
    header('Location: notLoggedIn.php');
}

// Hat der User den Admin Status wird es angezeigt.
if($user->hasPermission('admin')) {
echo '<p> Admin! </p>';
}

?>
  </body>
  </html>