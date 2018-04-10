<?php 
// CONVERT ALL APPLICABLE CHARACTERS TO HTML ENTITIES
    function escape($string) {
        return htmlentities($string, ENT_QUOTES, 'UTF-8');
    }
?>