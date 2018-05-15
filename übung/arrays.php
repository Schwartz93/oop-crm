<?php 
// Kurform
$arr1 = [
    'Erster String',
    'Zweiter String',
    'Dritter String',
    'Vierter String'
];



$arr1[] = 'Letzter String';
// Langform
$arr2 = array(
    'Erster String2',
    'Zweiter String2',
    'Dritter String2',
    'Vierter String2'
);
// Ausgabe des values mit implode getrennt durch komma
        echo implode(", ", $arr2) . "<br>";
// Ausgabe von key und value
    foreach($arr1 as $key => $value) {
        echo $key . "=>" . $value . "<br>";
    }
// Ausgabe von key und value
    foreach($arr1 as $value) {
        echo $value . "<br>";
    }
    echo "<hr>";
    // Assoziative Arrays
    $wochentage = [
        'mo' => 'Montag',
        'di' => 'Dienstag',
        'mi' => 'Mittwoch',
        'do' => 'Donnerstag'
    ];

    echo $wochentage['mo'];

    $wochentage['fr'] = 'Freitag';

    foreach($wochentage as $key => $value){
        echo $key . "=>" . $value . "<br>";
    }

    echo implode(", ", $wochentage);

    // Multidimensionale arrays
echo "<hr>";
    $mitarbeiter = [
        array("Klaus", "Nachname"),
        array("Peter", "Nachname"),
        array("Gustav", "Nachname")
    ];

    echo $mitarbeiter[0][0];
    echo $mitarbeiter[0][1];
    echo "<br>";
    // ODER:
    echo implode (", ", $mitarbeiter[0]);

echo "<hr>";

    // Implode function Eigenkreation (Nicht für Assoziative arrays :( )
    function michiplode($del, $array) {
        // $last erhält durch count -1 die Anzahl der Indizes
        $last = count($array) - 1; 
        // Mit foreach das Array durchlaufen
        foreach($array as $key => $value) {
            // Bei jedem Durchlauf prüfen ob der momentane $key (Index) dem letzten entspricht.
            // Falls nicht wird ein Delimiter ausgegeben.
            if($key !== $last) {
                echo $value . $del;
            // Ist der momentane $key gleich dem letzten Index des Arrays ($last) so wird nur der Wert ausgegeben
            //... aber nicht der Delimiter.
            } else {
                echo $value;
            }
        }
    }

    function michicount($array) {
        foreach($array as $key => $value) {
            $anzahl = $key;
        }

        $i = 0;

        while($i != $anzahl) {
            $i++;
        } 
        
        if($i === $key) {
            echo "Das Array hat eine Anzahl von " . $i . " Indizes";
        }
    }

    michicount($arr1);
echo "<hr>"; 
    michiplode(", ", $arr1);
?>