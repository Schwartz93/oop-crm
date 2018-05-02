<?php

/**
 * Klasse Cookie
 * 
 * Setzte cookies
 */
class Cookie {

    /**
     * Statische Funktion exists()
     * 
     * Checkt ob ein Cookie gesetzt ist bzw existiert.
     * 
     * Falls ja => return true
     * Falls nicht => return false
     * 
     */

    public static function exists($name){
        return (isset($_COOKIE[$name])) ? true : false;
    }

    /**
     * Statische Funktion get()
     * 
     * Gibt ein Cookie per return zurück
     * 
     * 
     */

    public static function get($name) {
        return $_COOKIE[$name];
    }

    /**
     * Statische Funktion put()
     * 
     * Setzt ein Cookie
     * 
     * Erwartet einen Namen, einen Wert und ein "Verfallsdatum"
     * 
     * time() => Aktuelle Zeit
     * 
     */

    public static function put($name, $value, $expiry) {
        if(setcookie($name, $value, time() + $expiry, '/')) {
            return true;
        }
        return false;
    }

    /**
     * Statische Funktion delete()
     * 
     * Löscht Cookies indem ein negativer Wert gesetzt wird.
     * 
     */

    public static function delete($name) {
        self::put($name, '', time() -1);
    }
}