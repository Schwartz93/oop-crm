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
            'password_current' => array(
                'required' => true,
                'min' => 6
            ),
            'password_new' => array(
                'required' => true,
                'min' => 6
            ),
            'password_new_again' => array(
                'required' => true,
                'min' => 6,
                'matches' => 'password_new'
            )
        ));
        // Check ob Validierung erfolgreich war.
        if($validation->passed()) {
            // Erstellt einen Hash aus dem aktuellen passwort und dem salt. Ist es nicht gleich dem eingegebenen passwort -> Nachricht dass das Passwort falsch ist
            if(Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->password) {
                echo 'Your current password is wrong.';
            } else { // Stimmen die Passwörter überein wird ein neuer salt generiert und mit dem neuen passwort in der DB aktualisiert
                $salt = Hash::salt(32);
                $user->update(array(
                    'password' => Hash::make(Input::get('password_new'), $salt),
                    'salt' => $salt
                ));
                // Flash nachricht wenn der updateprozess erfolgreich war und redirect zu index.php
                Session::flash('home', 'Your password has been changed.');
                Redirect::to('index.php');
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
<span class="back"><a href="index.php">Back To Home</a></span>
<form action="" method="post">
    <div class="field">
        <label for="password_current">Current password</label>
        <input type="password" name="password_current" id="password_current">
    </div>

    <div class="field">
        <label for="password_again">New password</label>
        <input type="password" name="password_new" id="password_new">
    </div>

    <div class="field">
        <label for="password_new_again">Confirm new password</label>
        <input type="password" name="password_new_again" id="password_new_again">
    </div>

    <input type="submit" value="Change">
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
</form>