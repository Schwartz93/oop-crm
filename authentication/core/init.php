<?php 
// Session wird gestartet
    session_start();
// Im $GLOBALS Array werden die DB Werte mit hilfe von assoziativen Arrays gespeichert.
    $GLOBALS['config'] = array(
        'mysql' => array(
            'host' => '127.0.0.1',
            'username' => 'root',
            'password' => 'root',
            'db' => 'crm'
        ),
// "Remember Me" mit Cookie Daten.
        'remember' => array(
            'cookie_name' => 'hash',
            'cookie_expiry' => 604800
        ),
// Session Details.
        'session' => array(
            'session_name' => 'user',
            'token_name' => 'token'
        )
    );
/**
 * spl_autoload_register (spl = Standard PHP Library): 
 * 
 * Lädt automatisch Klassen nach.
 * Erwartet Parameter -> Name der Funktion die eine Klasse laden soll. Hier: "$class".
 * $class steht für die Klassennamen im Ordner "classes".
 * 
 * Vorteil: PHP Datein müssen nicht per Hand reingeladen werden.
 * 
 * 
 */
    spl_autoload_register(function($class) {
        require_once 'classes/' . $class . '.php';
    });

    require_once 'functions/sanitize.php';

    // Checkt ob ein Cookie existiert, bzw ein User eingelogged ist.    
    if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
        // Falls ja wird in der Variable $hash das cookie gespeichert.
        $hash = Cookie::get(Config::get('remember/cookie_name'));
        // hashCheck Durchsucht die DB nach einem Hash der ident mit dem ist der gerade gesetzt ist.
        $hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));
        // Falls der Hash vorhanden ist wird ein User Objekt aufgerufen und der user mit einer bestimmten id zugewiesen => login Möglichkeit.
        if($hashCheck->count()) {
            $user = new User($hashCheck->first()->user_id);
            $user->login();
        }
    }

?>