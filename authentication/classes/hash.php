<?php

/**
 * Klasse Hash
 * 
 * Stellt Hash und Salt zur Verfügung
 * 
 */
class Hash {
    /**
     * Statische Methode make()
     * 
     * Erwartet einen String und $salt (Per Default auf Leerstring gesetzt).
     * 
     * Die Funktion hash() erwartet einen Algorithmus und einen String der "gehashed" werden soll. Hier zusammen mit $salt.
     * Kein passwort hat den selben Hash Wert da es gemeinsam mit dem Plaintext Password verschlüsselt wird.
     */

    public static function make($string, $salt = '') {
        return hash('sha256', $string . $salt);
    }

    /**
     * Statische Methode salt()
     * 
     * Erwartet die Länge die salt am Ende haben soll.
     * 
     * Zurückgegeben wird das Ergebnis der Funktion random_bytes. Diese gibt eine zufällige Zeichenabfolge aus mit der definierten Länge $length.
     */

    public static function salt($length) {
        return random_bytes($length);
    }

    /**
     * Statische Methode unique()
     * 
     * Nicht in Verwendung!!!
     */

    public static function unique() {
        return self::make(uniqid());
    }
}