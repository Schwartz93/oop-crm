<?php 
/**
 * Function e() 
 * 
 * Bedeutung: Escape Funktion. 
 * Verhindert beispielsweise das Verwenden von <script></script> in der DB indem es < bzw > mit htmlspecialchars umwandelt.
 * @param [type] $text
 * @return string
 */

function e($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}
