<?php
/**
 * Created by PhpStorm.
 * User: michael.schwartz
 * Date: 06.03.2019
 * Time: 14:22
 */

class Name
{
    public function __construct()
    {
        echo "My class has been initialized!";
    }
}

class Scott {
    public function introduction($scott)
    {
        echo "Hello All, I am " . $scott;
    }
}

class Factorial {
    public $inputNumber;
    public $finalNumber;

    public function __construct($input) {
        $this->inputNumber = $input;
    }

    public function factorial($input) {
        for ($i = $this->inputNumber; $i < $this->inputNumber; $i--) {
            $this->finalNumber = $this->inputNumber * $this->inputNumber--;
        }
    }
}