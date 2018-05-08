<?php

/**
 * Klasse Token 
 * 
 * Statische Methode generate()
 * 
 * Generiert einen Token der im Register Formular ausgegeben wird und sich mit jedem refresh ändert.
 * Die put() Methode erwartet hier wie in "session.php" beschrieben den namen des Token => aus dem assoziativen array auslesen
 * Hier mit Config::get('session/token_name').
 * Außerdem wird ein md5 hash verwendet (erwartet einen string) und uniqid() um eine "einzigartige" id zu erstellen.
 * 
 */

class Token {
    public static function generate() {
        return Session::put(Config::get('session/token_name'), md5(uniqid()));
    }

    /**
     * Methode check()
     * 
     * Soll überprüfen ob der Token in der aktuellen Session existiert.
     * Der Token Name wird in $tokenName gespeichert
     * 
     * Es wird mit if überprüft ob der Token Name in der Session existiert und ob der Parameter "$token" mit diesem übereinstimmt.
     * Ist das der Fall wird der Token Name gelöscht und true zurückgegeben.
     * 
     * Andernfalls wird false zurückgegeben.
     * 
     */

    public function check($token) {
        $tokenName = Config::get('session/token_name');

        if(Session::exists($tokenName) && $token === Session::get($tokenName)) {
            Session::delete($tokenName);
            return true;
        }
        return false;
    }
}