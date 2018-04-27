<?php 
/**
 *  Config Klasse: 
 *  
 *  Statische, öffentliche Funktion "get" wird definiert.
 *  Innerhalb der Klammern wird $path erstellt und gleich "null" gesetzt.
 *  $path wird anschließend mit "if" auf das Vorhandensein eines Werts überprüft.
 *  Ist das Ergebnis dieser if Abfrage true ($path enthält einen Wert), wird das "config" Array in einer Variable $config gespeichert.
 *  Mit "explode" wird ein Array von dem string $path (zb. ('mysql/host')) zurückgegeben und neu in der Variable $path gespeichert.
 *  Dieses Array wird mit der foreach Schleife durchlaufen. In $value werden die Werte des Arrays gespeichert.
 *  Mit "isset" wird überprüft ob die in $value gespeicherten Werte auch im "$GLOBALS" Array existieren.
 *  Existieren sie,werden sie einzeln in die $config Variable gespeichert und anschließend zrückgegeben.
 *  $config Wird bei jedem Schleifendurchlauf neu zugewiesen, da zu Beginn nur "mysql" teil des "config" Arrays ist. "host" ist Teil des "mysql" Arrays.
 *   Daher muss $config im nächsten Durchlauf auf "mysql" gesetzt werden.
 * 
 *  Wird $path kein Wert übergeben wird die Funktion mit return false beendet.
 * 
 *  
 *  Ziel: Output im Stil von: echo Config::get('mysql/host'); // 127.0.0.1
 *  Kann für PDO verwendet werden. 
 *  Vorteil: Sollte sich die Server/DB Config ändern, muss das im Code nicht mehr berücksichtigt werden.
 * 
 */
    class Config {
        public static function get($path = null) {
            if($path) {
                $config = $GLOBALS['config'];
                $path = explode('/', $path);

                foreach ($path as $value) {
                    if (isset($config[$value])) {
                        $config = $config[$value];
                    }
                }
                return $config;
            }
            return false;
        }
    }
?>