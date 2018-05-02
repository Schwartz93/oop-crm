<?php

/**
 * Klasse Session
 * 
 * Statische Methode exists()
 * 
 * $name wird als Parameter erwartet
 * 
 * Ist ein Session Token gesetzt wird true zurückgegeben. Andernfalls => false;
 */

class Session {
    public static function exists($name) {
        return (isset($_SESSION[$name])) ? true : false;
    }

    /**
     * Statische Methode put()
     * 
     * Nimmt einen Session Namen und einen Session Wert auf.
     * Anschließend wird dieser Wert dem Session Namen zugeordnet.
    */

    public static function put($name, $value) {
        return $_SESSION[$name] = $value;
    }

    /**
     * Statische Methode get()
     * 
     * Nimmt den eingegebenen Parameter und gibt den entsprechenden $_SESSION Eintrag zurück.
     * 
     */

    public static function get($name) {
        return $_SESSION[$name];
    }

    /**
     * Statische Methode delete()
     * 
     * Existiert ein Token wird dieser mit unset() entfernt. 
     * 
     */

    public static function delete($name) {
        if(self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    /**
     * Statische Methode flash()
     * 
     * Ermöglicht das Anzeigen eines Strings. Bei erneutem Refresh ist dieser nicht mehr zu sehen.
     * 
     * Mit if wird überprüft ob die Session existiert.
     * Falls ja, wird mit get($name) der Name der Session "geholt" und der Variable $session zugewiesen.
     * Danach wird die Session mit delete() gelöscht und zurückgegeben.
     * 
     * Existiert die Session zum Zeitpunkt der Abfrage nicht, werden mit put() Daten gesetzt.
     * 
     * 
     */

    public static function flash($name, $string = '') {
        if(self::exists($name)) {
            $session = self::get($name);
            self::delete($name);
            return $session;
        } else {
            self::put($name, $string);
        }
        return '';
    }
}