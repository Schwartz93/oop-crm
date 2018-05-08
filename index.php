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
    <link rel="stylesheet" href="authentication_css/main.css">
    
    <title>Home</title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <p class="welcome">Welcome <a class="navbar-brand" href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->username); ?></a></p>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Features</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Pricing</a>
      </li>
    </ul>
    <span class="navbar-text">
        <a href="logout.php"><img width="80px" height="80px" src="img/exit.svg" alt="logout_logo"></a>
    </span>
  </div>
</nav>
     










   <ul>
          <li><div class="update">
                <a href="update.php"><img width="100px" height="100px" src="img/update.svg" alt="update_logo">Update</a>
              </div>
          </li>
          <li>
            <a href="changepassword.php"><img width="100px" height="100px" src="img/password.svg" alt="password_logo">Change password</a>
          </li>
          <li>
            <a href="todo/index.php"><img width="100px" height="100px" src="img/todo.png" alt="todo_logo">Todo list</a>
          </li>
          <li>
            <a href="cms/admin/list.php"><img width="100px" height="100px" src="img/blog.svg" alt="blog_logo">Blog</a>
          </li>
          <li>
            <a href="poll/index.php"><img width="100px" height="100px" src="img/elections.svg" alt="poll_logo">Poll</a>
          </li>
          <li>
            <a href="timetracking/index.php"><img width="100px" height="100px" src="img/hourglass.svg" alt="timetracking_logo">Timetracker</a>
          </li>
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