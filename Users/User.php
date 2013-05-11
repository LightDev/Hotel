<?php

abstract class User {

//    public function __construct($id, $name, $surname, $login, $password) {
//        $this->_id = $id;
//        $this->_login = $login;
//        $this->_name = $name;
//        $this->_surname = $surname;
//        $this->_password = $password;
//        $this->conn = PHP_Helper::getConnection();
//    }

    public function __construct($name, $surname, $login, $password) {
        $this->_login = $login;
        $this->_name = $name;
        $this->_surname = $surname;
        $this->setPassword($password);
        $this->_password = SHA1($password);
        //$this->_password = $password;
        $this->conn = PHP_Helper::getConnection();
    }

    public function addUser() {
        
    }

    public function getId() {
        return $this->_id;
    }

    public function getName() {
        return $this->_name;
    }

    public function getSurname() {
        return $this->_surname;
    }

    public function getLogin() {
        return $this->_login;
    }

    public function setPassword($password) {
        $passwordLenght = strlen($this->_password);
        if ($passwordLenght >= 6 && $passwordLenght <= 40) {
            $this->_password = $password;
        } else {
            throw new Exception("<p>Hasło musi posiadać od 8 do 40 znaków.</p>");
        }
    }

    public function getPassword() {
        return $this->_password;
    }

    protected $_id;
    protected $_name;
    protected $_surname;
    protected $_login;
    protected $_password;
    protected $_conn;

}

?>
