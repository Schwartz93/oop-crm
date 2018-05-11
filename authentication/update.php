<?php
require_once 'core/init.php';
// Neues Objekt wird instanziert
$user = new User();
// Check ob ein User ist eingelogged. Falls nicht => Redirect zu index.php
if(!$user->isLoggedIn()) {
    Redirect::to('index.php');
}
// Check ob der Token korrekt ist.
if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
        // Validation Klasse checkt ob das eingegebene Valide ist (Vergleichbar mit register.php)
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            )
        ));
        // Check ob Validierung erfolgreich war.
        if($validation->passed()) {
            // Versuch zu updaten
            try {
                $user->update(array(
                    'name' => Input::get('name')
                ));
                // Wenn die Update Funktion erfolgreich war => Flash mit einer Nachricht und Redirect zu index.php
                Session::flash('home', 'Your details have been updated.');
                Redirect::to('index.php');
            // Exception Error falls der Versuch zu updaten fehl schlägt.
            } catch(Exception $e) {
                die($e->getMessage());
            }
        // Error Ausgabe falls Validierung fehl schlägt
        } else {
            foreach($validation->errors() as $error) {
                echo $error, '<br>';
            }
        }
    }
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="authentication_css/main.css">
    <link rel="stylesheet" href="authentication_css/register.css">
    <link rel="stylesheet" href="authentication_css/update_details.css">

    <title>Home</title>
  </head>
  <body onload="startTime()">
  <script> 
$(document).ready(function(){
   $(".notice").slideDown("slow");
});
</script>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <p class="welcome">Update Name</p>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php"><img src="../img/house.svg" width="30px" height="30px" alt="home_logo"><span class="sr-only">(current)</span></a>
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
<!-- Javascript für die Ausgabe der Uhrzeit -->
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
<!-- Ausgabe der Uhrzeit -->
<div class="time">
  <div id="current_time"></div>
</div>
<div class="notice">
    <p class="notice_p">Change your name info in the input field below! Click "Update" to update your name in the Database</p>
</div>
<div class="form-wrapper-changepw">
<form action="" method="post">
    <div class="field">
        <label for="name">Name</label>
        <input class="form-control" type="text" name="name" id="name" value="<?php echo escape($user->data()->name); ?>">

        <input class="btn btn-primary" type="submit" value="Update">
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

    </div>
    </div>
</form>

<!-- Footer Anfang -->    
<footer>
    <div class="footer">
        <div>
            <p class="copyright">CRM 2018 - Michael Schwartz</p>
        </div>
    </div>
</footer>
  </body>
  </html>