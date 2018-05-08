<?php 
/**
 * Klasse Redirect
 * 
 * Statische Methode to()
 * 
 * Erwartet eine Location. Per Default gleich "null".
 * 
 * Das erste if prüft ob eine location gesetzt wurde.
 * Das zweite if Statement prüft ob $location eine Nummer ist. Ist das der Fall und die Nummer entspricht 404,
 * wird mit der header() Funktion auf eine eigens gesetzte Errorpage verwiesen.
 * 
 * Ist $location keine Nummer wird versucht dorthin umzuleiten.
 * exit() beendet die Methode
 * 
 */
class Redirect {
    public static function to($location = null) {
        if($location) {
            if(is_numeric($location)) {
                switch ($location) {
                    case 404:
                      header('HTTP/1.0 404 Not Found');
                      include 'includes/errors/404.php';
                    break;
                }
            }
            header('Location: ' . $location);
            exit();
        }
    }
}