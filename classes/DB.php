<?php 
/**
 * DB Klasse wird erstellt.
 * 
 * Statische Eigenschaft werden gesetzt: $instance per Default gleich "null".
 * private Eigenschaften werden definiert:
 * Zum Einsatz kommt das sogenannte Singleton Pattern.
 * Underscore in den Eigenschaftsnamen um klar zu machen dass sie "private" sind.
 * 
 * - $instance: Eine Art "Hauptklasse" die dafür sorgt, dass eine Instanz des selben Objekts aufgerufen wird und nicht mehrmals versucht wird sich mit der DB zu verbinden.
 * - $_pdo: Wird ein PDO Objekt instanziert, wird es hier gespeichert.
 * - $_query: Letzte ausgeführte Query.
 * - $_error: Vorhandensein eines Errors. Zb falls die Query fehlschlägt.
 * - $_results: Speichert das Resultset => (SELECT * FROM users WHERE username = "alex";)
 * - $_count: Anzahl der Ergebnisse.
 * 
 * 
 */
class DB {
    private static $_instance = null;
    private $_pdo,
            $_query,
            $_error = false,
            $_results,
            $_count = 0;

    /**
     * __construct => Magische Methode: Wird beim instanzieren des Objekts automatisch ausgeführt. Übergebene Parameter werden beim erzeugen des Objekts eingefügt. 
     * Try/Catch: Im try Block wird getestet. Catch wirft einen Fehler sofern vorhanden. 
     * die(); => Beendet das Statement im Falle eines Fehlers und gibt mit der "getMessage()" - Methode eine Fehlermeldung aus.
     * Alternativ im Try Block: Mit: throw new Exception("Eine beliebige Error Message"); => Error Nachricht selbst erzeugen.
     * 
     * Mit $this->_pdo auf die entsprechende Eigenschaft zugreifen. Ein neues PDO - Objekt instanizieren.
     * Die Datenbank Eigenschaften mit der in "config.php" erstellten statischen Methode "get()" eintragen.
     */

    private function __construct() {
        try {
            $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }
    /**
     * 
     * getInstance() => Checkt ob das Objekt bereits durch die Datenbankverbindung instanziert wurde.
     * Falls nicht: Wird das Objekt instanziert.
     * "self::" => Spricht statische Eigenschaften innerhalb der Klassendefinition an. Vergleichbar mit "$this->".
     * mit self::$_instance = new DB(); wird das Objekt instanziert falls noch nicht geschehen. (Soll verhindern, dass die Db Verbindung mehrmals hergestellt wird).
     * Beim instanzieren wird die constructor Methode "aktiviert", die DB Verbindung hergestellt und anschließend in $_pdo gespeichert.
     * Anschließend per return zurückgegeben.
     * 
     */
    public static function getInstance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    /**
     * Query Methode:
     * 
     * Die Funktion "query" erwartet ein $sql Statement, und ein Array von Parametern falls Verwendung dafür besteht.
     * 
     * _error wird auf "false" gesetzt (reset) um zu verhindern das bei setzen mehrerer queries eine error Meldung für die vorhergehende Query am falschen Platz erscheint. 
     * Innerhalb der ersten if-Abfrage wird geprüft ob die DB Verbindung new PDO => $_pdo, erfolgreich hergestellt wurde.
     * Das PDO prepare() Statement, bereitet ein SQL Statement vor und kann ein oder mehrere "?" Parameter erhalten die innerhalb des SQL Statements für diverse Werte stehen.
     * Ist das Ergebnis der if- Abfrage true, sprich das verwendete SQL Statement wurde erfolgreich vorbereitet, wird mit count() gecheckt ob das $params array werte enthält bzw werden diese gezählt.
     * Mit Hilfe der foreach Schleife werden die Werte des Arrays $params als $param gespeichert bzw durchlaufen. Die PDO Methode "bindValue()" bindet einen Wert an einen Parameter. Hier die Variable $x die als Counter genutzt wird.
     */

    public function query($sql, $params = array()) {
        $this->_error = false;
        if ($this->_query = $this->_pdo->prepare($sql)) {
            $x = 1;
            if(count($params)) {
                foreach($params as $param) {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }

            if($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }
        }
        return $this;
    }

    public function action($action, $table, $where = array()) {
        if (count($where) === 3) {
            $operators = array('=', '>', '<', '>=', '<=');

            $field    = $where[0];
            $operator = $where[1];
            $value    = $where[2];

            if(in_array($operator, $operators)) {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";

                if (!$this->query($sql, array($value))->error()) {
                    return $this;
                }
            }
        }
        return false;
    }

    public function get($table, $where) {
        return $this->action('SELECT *', $table, $where);
    }

    public function delete($table, $where) {
        return $this->action('DELETE', $table, $where);
    }

    public function insert($table, $fields = array()) {
        $keys = array_keys($fields);
        $values = '';
        $x = 1;

        foreach($fields as $field) {
            $values .= '?';
            if($x < count($fields)) {
                $values .= ', ';
            }
            $x++;
        }

        $sql = "INSERT INTO {$table} (`". implode('`,`', $keys) ."`) VALUES ({$values})";

        if(!$this->query($sql, $fields)->error()) {
            return true;
        }

        return false;
    }

    public function update($table, $id, $fields) {
        $set = '';
        $x = 1;

        foreach ($fields as $name => $value) {
            $set .= "{$name} = ?";
            if($x < count ($fields)) {
                $set .= ', ';
            }
            $x++;
        }
        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
        
        if(!$this->query($sql, $fields)->error()) {
            return true;
        }

        return false;
    }

    public function results() {
        return $this->_results;
    }

    public function first() {
        return $this->results()[0];
    }

    public function error() {
        return $this->_error;
    }

    public function count() {
        return $this->_count;
    }
} 
?>