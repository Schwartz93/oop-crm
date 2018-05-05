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
      <p>Hello <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->username); ?></a>!</p>

        <ul>
            <li><a href="logout.php">Log out</a></li>
            <li><a href="update.php">Update Details</a></li>
            <li><a href="changepassword.php">Change Password</a></li>
            <li><a href="todo/index.php">Todo App</a></li>
            <li><a href="cms/admin/list.php">CMS/Blog</a></li>
            <li><a href="timetracking/index.php">Timetracker</a></li>
        </ul>

  <?php
// Ist der User nicht eingelogged, bekommt er die Möglichkeit dazu. Auch ein link zum registrieren wird angezeigt.
} else {
      echo '<p>You need to <a href="login.php">log in</a> or <a href="register.php">register</a></p>';
  }

  // Hat der User den Admin Status wird es angezeigt.
  if($user->hasPermission('admin')) {
    echo '<p> Admin! </p>';
}

  ?>
  