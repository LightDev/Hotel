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
//        $this->_login = $login;
//        $this->_name = $name;
//        $this->_surname = $surname;
        $this->setName($name);
        $this->setSurname($surname);
        $this->setLogin($login);
        $this->setPassword($password);
        //$this->_password = SHA1($password);
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

    public function setName($name) {
        echo 'dopasoawelm oimie';
        echo preg_match(PHP_Helper::TEXT_PATTERN, $name);
        if (preg_match(PHP_Helper::TEXT_PATTERN, $name)) {
            echo 'dopasoawelm oimie';
            $this->_name = ucfirst(strtolower($name));
        } else {
            echo '<p>Imię nie może zawierać cyfr.</p>';
//throw new Exception("<p>Hasło musi posiadać od 8 do 40 znaków.</p>");
        }
    }

    public function getSurname() {
        return $this->_surname;
    }

    public function setSurname($surname) {
        if (preg_match(PHP_Helper::TEXT_PATTERN, $surname)) {
            $this->_surname = ucfirst(strtolower($surname));
        } else {
            echo '<p>Nazwisko nie może zawierać cyfr.</p>';
//throw new Exception("<p>Hasło musi posiadać od 8 do 40 znaków.</p>");
        }
    }

    public function getLogin() {
        return $this->_login;
    }

    public function setLogin($login) {
        $lenght = strlen($login);
        if ($lenght >= 5 && $lenght <= 15) {
            $this->_login = $login;
        } else {
            echo '<p>Login musi posiadać od 5 do 15 znaków.</p>';
//throw new Exception("<p>Hasło musi posiadać od 8 do 40 znaków.</p>");
        }
    }

    public function getPassword() {
        return $this->_password;
    }

    public function setPassword($password) {
        $passwordLenght = strlen($password);
        if ($passwordLenght >= 6 && $passwordLenght <= 40) {
            $this->_password = SHA1($password);
        } else {
            echo '<p>Hasło musi posiadać od 6 do 40 znaków.</p>';
//throw new Exception("<p>Hasło musi posiadać od 8 do 40 znaków.</p>");
        }
    }

    protected $_id;
    protected $_name;
    protected $_surname;
    protected $_login;
    protected $_password;
    protected $_conn;

}

?>
