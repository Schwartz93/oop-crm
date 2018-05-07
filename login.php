<?php
    require_once 'core/init.php';
    // Input überprüft ob POST oder GET Werte erhalten haben
    if(Input::exists()) {
        // Es wird überprüft ob der Token korrekt ist
        if(Token::check(Input::get('token'))) {
            // Validation Klasse wird genutzt um username und password zu validiern bzw 'require' auf true zu setzen.
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'username' => array('required' => true),
                'password' => array('required' => true)
            ));

            // Wenn die Validierung erfolgreich ist, wird ein User Objekt instanziert und eingelogged.
            if($validation->passed()) {
                $user = new User();
                // $remember enthält den wert true oder false, je nachdem ob man die "remember me" checkbox aktiviert hat oder nicht.
                $remember = (Input::get('remember') === 'on') ? true : false;
                // Mit Hilfe der login() Methode werden die Userdaten in $login gespeichert. 
                $login = $user->login(Input::get('username'), Input::get('password'), $remember);
                // Ist der User eingelogged => Redirect. Andernfalls => Error Message
                if($login) {
                    Redirect::to('index.php');
                } else {
                    echo '<p>Sorry, login failed.</p>';
                }
            // Schlägt die Validierung fehl werden wieder Error Messages ausgegeben.
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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
  <link rel="stylesheet" href="authentication_css/login.css">

  <title>Login</title>
</head>
<body>
<div class="jumbotron">
    <h1 class="display-5">Login</h1>
        <p class="lead">
            Please put in your username and your password.<br>
            If you need to register first, there is a link for that too!
        </p>
  </div>
    <div class="underline"></div>
    <div class="form-wrapper">
        <form action="" method="post">
            <div class="form-group">
                <div class="field">
                    <label for="username">Username</label>
                    <input class="form-control" type="text" name="username" id="username" autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <div class="field">
                    <label for="password">Password</label>
                    <input class="form-control" type="password" name="password" id="password" autocomplete="off">
                </div>
            </div>
                <div class="field">
                    <label for="remember">
                        <input type="checkbox" name="remember" id="remember"> Remember Me
                    </label>
                </div>
            <div class="form-group">
                <div class="field">
                    <a href="register.php"> Need an account? Click Here</a>
                </div>
            </div>  
                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                <input class="btn btn-primary" type="submit" value="Log in">
        </form>
    </div>
</body>
</html>