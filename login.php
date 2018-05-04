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

<form action="" method="post">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" autocomplete="off">
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" autocomplete="off">
    </div>

    <div class="field">
        <label for="remember">
            <input type="checkbox" name="remember" id="remember"> Remember Me
        </label>
    </div>

    <div class="field">
        <a href="register.php"> Need an account? Click Here</a>
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" value="Log in">
</form>