<?php
/**
 * Klasse Input
 * 
 * Statische Methode exists()
 * Wird $_GET nicht speziell definiert, ist "type" per default $_POST. 
 * Checkt ob $_POST bzw $_GET Werte enthalten. Sollten beide leer sein, wird false zurückgegeben.
 * 
 * 
 */

class Input {
    public static function exists($type = 'post') {
        switch($type) {
            case 'post':
                return (!empty($_POST)) ? true : false;
            break;
            case 'get':
            return (!empty($GET)) ? true : false;
            break;
            default:
               return false;
            break; 
        }
    }

    /**
     * Statische Methode get()
     * 
     * Gibt ein Array Element aus POST oder GET zurück wenn vorhanden.
     * 
     */

    public static function get($item) {
        if(isset($_POST[$item])) {
            return $_POST[$item];
        } else if(isset($_GET[$item])) {
            return $_GET[$item];
        }
        return '';
    }
}