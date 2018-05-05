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
<span class="back"><a href="index.php">Back To Home</a></span>
<form action="" method="post">
    <div class="field">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="<?php echo escape($user->data()->name); ?>">

        <input type="submit" value="Update">
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

    </div>
</form>