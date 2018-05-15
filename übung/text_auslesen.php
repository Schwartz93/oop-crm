<?php 

// Gibt die gesamte Seite als String aus.
$test =  file_get_contents('test.txt');
echo $test;

// Öffnet das Dokument
$file = fopen("test.txt", "r");
// Solange der Zeiger nicht am Ende angekommen ist, => Ausgeben!
while(!feof($file)) {
    echo fgets($file);
}
fclose($file);

?>