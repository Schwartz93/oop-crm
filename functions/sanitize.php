<?php 
/**
 * 
 * Die funktion "escape" erwartet einen String. 
 * Optional: "flags". Hier verwendet: ENT_QUOTES => Codiert single und double quotes im Stil von: &#039;SingleQuotes&#039; bzw. &quot;DoubleQuotes&quot;
 * Optional: Charset: Hier verwendet: UTF-8
 * 
 * Aufgabe: Der als Parameter eingefügte String wird in die htmlentities Funktion eingefügt und ihr Ergebnis mit return zurückgegeben.
 */
    function escape($string) {
        return htmlentities($string, ENT_QUOTES, 'UTF-8');
    }
?>