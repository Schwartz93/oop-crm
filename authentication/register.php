<?php 
require_once 'core/init.php';
    // Mit exists() auf den Erhalt von POST bzw GET Daten überprüfen.
    if(Input::exists()) {

        if(Token::check(Input::get('token'))) {
            // $validate => Neues Objekt "Validate"
            $validate = new Validate();
            // $validation => Objekt $validate => check() überprüft POST und die "Rules" in einem Array.
            $validation = $validate->check($_POST, array(
                'username' => array(
                    'required' => true,
                    'min' => 2,
                    'max' => 20,
                    'unique' => 'users'
                ),
                'password' => array(
                    'required' => true,
                    'min' => 6
                ),
                'password_again' => array(
                    'required' => true,
                    'matches' => 'password'
                ),
                'name' => array(
                    'required' => true,
                    'min' => 2,
                    'max' => 50
                )
            ));
            // Mit passed() überprüfen ob die Validierung erfolgreich war. Falls ja, neues User Objekt instanzieren und $salt erstellen.
            if($validation->passed()) {
                $user = new User();

                $salt = Hash::salt(32);
                
                // Das Objekt $user verwendet die Methode create (Siehe user.php!) um das assoziative. Array mit den Userdaten zu füllen.
                try {
                    $user->create(array(
                        'username' => Input::get('username'),
                        'password' => Hash::make(Input::get('password'), $salt),
                        'salt' => $salt,
                        'name' => Input::get('name'),
                        'joined' => date('Y-m-d H:i:s'),
                        'group_id' => 1
                    ));
                    // Nachricht "flash" wenn erfolgreich registriert wurde. Redirect zu index.php
                    Session::flash('home', 'You have been registered and can now log in!');
                    Redirect::to('index.php');

                //Exception Message falls Registrierung fehl schlägt.  
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            // War die Validierung nicht erfolgreich werden entsprechen Error messages ausgegeben.
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
  <link rel="stylesheet" href="authentication_css/register.css">

  <title>Login</title>
</head>
<body>
<div class="jumbotron">
    <h1 class="display-5">Register</h1>
        <p class="lead">
            Please choose your Username and password.<br>
            After re-entering your password,
            type in you full name.
        </p>
  </div>
  <div class="underline"></div>
  <div class="form-wrapper">
        <form action="" method="post">
        <div class="form-group">
            <div class="field">
                <label for="username">Username</label>
                <input class="form-control" type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off">
            </div>
        </div>
        <div class="form-group">
            <div class="field">
                <label for="password">Choose a password</label>
                <input class="form-control" type="password" name="password" id="password">
            </div>
        </div>
        <div class="form-group">
            <div class="field">
                <label for="password_again">Enter your password again</label>
                <input class="form-control" type="password" name="password_again" id="password_again">
            </div>
        </div>
        <div class="form-group">
            <div class="field">
                <label for="name">Enter your name</label>
                <input class="form-control" type="text" name="name" value="<?php echo escape(Input::get('name')); ?>" id="name">
            </div>
        </div>
        <div class="form-group">
                <div class="field">
                    <a href="login.php">Already have an account? Click Here to login</a>
                </div>
        </div>  
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

            <input class="btn btn-primary" type="submit" value="Register">
        </form>
    </div>
</body>
<footer>
    <div class="footer">
        <div>
            <p>CRM 2018 - Michael Schwartz</p>
        </div>
    </div>
</footer>
</html>