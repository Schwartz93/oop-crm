<?php

/**
 * Klasse Validate
 * 
 * Eigenschaften: $_passed, $_errors, $_db;
 * 
 * Methode: __construct() => Aufgerufen wenn die Validate Klasse instanziert wurde. Die Instanz wird in $_db gespeichert.
 * 
 * Methode: check() => Erwartet eine "Quelle" hier $_POST und ein Array mit den Rules.
 * 
 * Mit der ersten foreach Schleife das $items array durchlaufen => 'username', 'password', 'password_again' und 'name'.
 * $rules entspricht den verschachtelten arrays innerhalb von 'username', 'password', etc. Also: 'require', 'min' ....
 * 
 * Mit der zweiten foreach Schleife durch $rules laufen und die values als $rule_value definieren.
 * 
 * Es wird mit if überprüft ob $rule === 'required' und ob $value leer ist. => Error
 * Ist $value nicht leer wird mit switch case geprüft ob die eingetragenen Werte den $rules entsprechen.
 * 
 * Beispiel: if (strlen($value) < $rule_value) {
                                $this->addError("{$item} must be a minimum of {$rule_value} characters.");
                            }
 * 
 * 
 * 
 */

class Validate {
    private $_passed = false,
            $_errors = array(),
            $_db = null;

    public function __construct() {
        $this->_db= DB::getInstance();
    }

    public function check($source, $items = array()) {
        foreach ($items as $item => $rules) {
            foreach($rules as $rule => $rule_value) {
               
                $value = trim($source[$item]);
                $item = escape($item);
                
                if($rule === 'required' && empty($value)) {
                    $this->addError("{$item} is required");
                } else if(!empty($value)) {
                    switch($rule) {
                        case 'min' :
                            if (strlen($value) < $rule_value) {
                                $this->addError("{$item} must be a minimum of {$rule_value} characters.");
                            }
                        break;
                        case 'max' : 
                        if (strlen($value) > $rule_value) {
                            $this->addError("{$item} must be a maximum of {$rule_value} characters.");
                        }
                        break;
                        case 'matches' :
                            if($value != $source[$rule_value]) {
                                $this->addError("{$rule_value} must match {$item}");
                            }
                        break;
                        case 'unique' : 
                            $check = $this->_db->get($rule_value, array($item, "=", $value));
                            if($check->count()) {
                                $this->addError("{$item} already exists.");
                            }
                        break;
                    }
                }

            }
        } 
            if(empty($this->_errors)) {
                $this->_passed = true;
        }

        return $this;
    }

    /**
     * Methode addError()
     * 
     * Fügt einen Error zum errors array hinzu
     */

    private function addError($error) {
        $this->_errors[] = $error;
    }

    /**
     * Methode errors()
     * 
     * Gibt error zurück
     */

    public function errors() {
        return $this->_errors;
    }

    /**
     * Methode passed()
     * 
     * Gibt $_passed zurück. Per default false, wenn keine Fehler vorhanden => true; 
     */

    public function passed() {
        return $this->_passed;
    }
}