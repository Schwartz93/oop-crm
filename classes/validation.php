<?php

/**
 * Klasse Validate
 * 
 * Eigenschaften: $_passed, $_errors, $_db;
 * 
 * Methode: __construct() => Aufgerufen wenn die Validate Klasse instanziert wurde. Die Instanz wird in $_db gespeichert.
 * 
 * Methode: check() => Erwartet eine "Quelle" hier $_POST und ein Array mit den Rules.
 * Mit der ersten foreach Schleife das erste Array durchlaufen => 'username', 'password', 'password_again' und 'name'.
 * 
 * 
 * 
 */

class Validate {
    private $_passed = false,
            $_errors = array(),
            $_db = null;

    public function __construct() {
        $this->_db = DB::getInstance();
    }

    public function check($source, $items = array()) {
        foreach ($items as $item => $rules) {
            foreach($rules as $rules => $rule_value) {
                echo "{$item} {$rule} must be {$rule_value}<br>";
            }
        }
    }
}