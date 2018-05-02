<?php

/**
 * Klasse User
 * 
 * Ermöglicht die Arbeit mit User Daten aus der DB.
 * 
 * Eigenschaften: $_db,
                  $_data,
                  $_sessionName,
                  $_cookieName,
                  $_isLoggedIn;
 * 
 */
class User {
    private $_db,
            $_data,
            $_sessionName,
            $_cookieName,
            $_isLoggedIn;
           
    /**
     * Methode __construct
     * 
     * Erzeugt eine neue Instanz 
     * 
     * Sowohl Sessiondaten als auch Cookies werden in entsprechenden Eigenschaften gespeichert.
     * 
     * Falls User nicht definiert wurde:
     * Überprüft wird ob Session existiert.
     * $user wird dem Session Namen gleichgesetzt.
     * 
     * $user wird mit find() in der Db gesucht.
     * Ist das Ergebnis true, wird die Eigenschaft $isLoggedIn auch auf true gesetzt.
     * 
     * Falls User definiert wurde:
     * User wird mit find() "gesucht".
     */

    public function __construct($user = null){
        $this->_db = DB::getInstance();

        $this->_sessionName = Config::get('session/session_name'); 
        $this->_cookieName = Config::get('remember/cookie_name');

        if(!$user) {
            if(Session::exists($this->_sessionName)) {
                $user = Session::get($this->_sessionName);
                
                
                if($this->find($user)) {
                    $this->_isLoggedIn = true;
                } else {
                    //process Logout
                }
            }
        } else {
            $this->find($user);
        }

    }

    /**
     * Methode update()
     * 
     * Updated Daten in der DB.
     * 
     * Mit if prüfen ob eine id vorhanden ist und der User eingelogged ist
     * Falls das der Fall ist, wird $id dem aktuellen Wert zugeordnet den die User id hat.
     * 
     * Das zweite if checkt ob die _db->update() Methode erfolgreich war. 
     * Falls nicht => Exception Message.
     */

    public function update($fields = array(), $id = null) {

        if(!$id && $this->isLoggedIn()) {
            $id = $this->data()->id;
        }
    
        if(!$this->_db->update('users', $id, $fields)) {
            throw new Exception("There was a problem updating your Information");
            
        }
    }

    /**
     * Methode create()
     * 
     * Erzeugt einen Datensatz in der users Tabelle.
     * 
     * Erwartet ein Array als Parameter.
     * Wirft eine Exception Message falls die insert() Methode fehlschägt.
     * 
     * Erklärung zur insert() Methode in DB.php!
     * 
     * 
     */

    public function create($fields = array()) {
        if(!$this->_db->insert('users', $fields)) {
            throw new Exception("There was a problem creating an account.");
        }
    }

    /**
     * Methode find()
     * 
     * Erwartet einen user (Per default gleich "null")
     * Mit if wird geprüft ob ein user vorhanden ist. 
     * 
     * $field checkt ob $user eine Nummer ist. Falls ja wird => 'id' gesetzt. Falls nicht => 'username'.
     * $data entspricht den Daten die aus der 'users' Tabelle zurückkommen. 
     * 
     * Beispiel: SELECT * FROM users WHERE $field (entspricht hier entweder 'id' oder 'username') = $user.
     *  
     * Mit dem zweiten if und count() überprüfen ob Daten vorhanden sind. 
     * Das erste Ergebnis dieser Daten wird in der Eigenschaft $data gespeichert.
     * true wird zurückgegeben
     * 
     * false wird zurückgegeben falls $user nicht existiert.
     */

    public function find($user = null) {
        if($user) {
            $field = (is_numeric($user)) ? 'id' : 'username';
            $data = $this->_db->get('users', array($field, '=', $user));

            if($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    /**
     * Statische Methode login()
     * 
     * Erwartet username und password. (Per default gleich "null") 
     * 
     * 
     * 
     * Falls $user existiert:
     * Wird überprüft ob der Passwort Hash in der DB dem Passwort Hash und dem Salt entspricht das aus dem eingegebenen Passwort entsteht.
     * Ist das der Fall wird eine Session erstellt und die User id gespeichert.
     * 
     * Wird "remember" genutzt, prüft ein hash Check ob ein hash gesetzt wurde.
     * Wenn kein Hash vorhanden ist, werden user_id und hash in die Db eingetragen
     * 
     * Ist ein Hash vorhanden wird dieser in der Variable $hash gespeichert.
     *  
     * Cookie wird gesetzt mit dem cookie Namen aus config.php
     * Hash => Wert
     * Config::get('remember/cookie_expiry') => expiry
     * 
     */

    public function login($username = null, $password = null, $remember = false) {
        
        if(!$username && !$password && $this->exists()) {
            Session::put($this->_sessionName, $this->data()->id);
        } else {
            $user = $this->find($username);

            if($user) {
                if($this->data()->password === Hash::make($password, $this->data()->salt)) {
                    Session::put($this->_sessionName, $this->data()->id);

                    if($remember) {
                        $hash = Hash::unique();
                        $hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));

                        if(!$hashCheck->count()) {
                            $this->_db->insert('users_session',array(
                                'user_id' => $this->data()->id,
                                'hash' => $hash
                            ));
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }

                        Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));

                    }
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Methode hasPermission()
     * 
     * $group erhählt die group_id aus der DB für den aktuellen User.
     * Hat $group einen Wert wird das Json File in der DB mit json_decode als array zurückgegeben.
     * 
     * 
     */

    public function hasPermission($key) {
        $group = $this->_db->get('groups', array('id', '=', $this->data()->group_id));
        
        if($group->count()) {
            $permissions = json_decode($group->first()->permissions, true);
            
            if($permissions[$key] == true) {
                return true;
            }
        }
        return false;
    }

    /**
     * Methode exists()
     * 
     * Checkt ob die Daten im data Array enthalten sind.
     * 
     */

    public function exists() {
        return (!empty($this->_data)) ? true : false;
    }

    /**
     * Method logout()
     * 
     * Hash wird zurückgesetzt bzw gelöscht.
     * 
     * Session wird gelöscht.
     * Cookies werden gelöscht.
     * 
     */

    public function logout() {

        $this->_db->delete('users_session', array('user_id', '=', $this->data()->id));

        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
    }

    /**
     * Methode data()
     * 
     * Gibt $_data zurück
     */

    public function data() {
       return $this->_data; 
    }

    /**
     * Methode isLoggedIn()
     * 
     * Gibt $_isLoggedIn zurück
     */

    public function isLoggedIn() {
        return $this->_isLoggedIn;
    }

}