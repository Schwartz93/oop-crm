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
<form action="" method="post">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off">
    </div>

    <div class="field">
        <label for="password">Choose a password</label>
        <input type="password" name="password" id="password">
    </div>

    <div class="field">
        <label for="password_again">Enter your password again</label>
        <input type="password" name="password_again" id="password_again">
    </div>

    <div class="field">
        <label for="name">Enter your name</label>
        <input type="text" name="name" value="<?php echo escape(Input::get('name')); ?>" id="name">
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

    <input type="submit" value="Register">
</form>