<?php

class HotelGuest extends User {

    /**
     * 
     * fake przeladowania konstruktora 
      glowne ograniczenie problem przy potrzebie skorzystania z co najmniej 2och
      konstruktorow o takiej samej liczbie parametrow.
      wtedy dodatkowo w kostruktorze mozna zarzucic ifa na dany typ isArray itp;
      kluczowa okazala się nazwa konstruktora tzn 5 parametrowy musi nazywac miec 5 w nazwie
     * 
     */
    public function __construct() {
        $this->_this_conn = PHP_Helper::getConnection(); //parent::_conn;
        $argv = func_get_args();
        switch (func_num_args()) {
            case 1:
                self::__construct1($argv[0]);
                break;
            case 5:
                self::__construct5($argv[0], $argv[1], $argv[2], $argv[3], $argv[4]);
                break;
        }
    }

    public function __construct1($arg1) {
        
    }

    function __construct5($name, $surname, $login, $password, $cardId) {
        parent::__construct($name, $surname, $login, $password);
        $this->_cardId = $cardId;
    }

// Factory Method Pattern ale musi miec od wlasne  zmienne inaczej nie mozna sie odwolac przez $this co daje nulla przy getach()
//    public static function HotelGuestSimple($name, $surname, $login, $password, $cardId) {
//        //parent::__construct($name, $surname, $login, $password);
//        $obj = new HotelGuest();
//        //parent::setName($name);
//        $obj->setName($name);
//        $obj->_surname = $surname;
//        $obj->_login = $login;
//        $obj->_password = $password;
//        //$obj->_cardId = $cardId;
//
//        $obj->setCardId($cardId);
//        return $obj;
//    }

    public function addUser() {
        $Name = $this->getName();
        $Surname = $this->getSurname();
        $Login = $this->getLogin();
        $Password = $this->getPassword();
        $CardId = $this->getCardId();

        $expr = oci_parse($this->_this_conn, "declare isLoginExist NUMBER:=0; begin HOTEL.ADDHOTELGUEST(:isLoginExist,:imie,:nazwisko,:login,:haslo,:nr_karty); end;");
        oci_bind_by_name($expr, ":isLoginExist", $isLoginExist);
        //echo ($isGood == 0) ? '<br>Procedura wykonana poprawnie<br>' : 'Blad procedury';
        //new Exception(($isGood == 0) ? '<br>Procedura wykonana poprawnie<br>' : 'Blad procedury');
        oci_bind_by_name($expr, ":imie", $Name, -1);
        oci_bind_by_name($expr, ":nazwisko", $Surname, -1);
        oci_bind_by_name($expr, ":login", $Login, -1);
        oci_bind_by_name($expr, ":haslo", $Password, -1);
        oci_bind_by_name($expr, ":nr_karty", $CardId, -1);
        $check = oci_execute($expr);
        if ($check == true)
            $commit = oci_commit($this->_this_conn);
        else
            $commit = oci_rollback($this->_this_conn);

        //echo $isLoginExist;
        oci_free_statement($expr);
        return $isLoginExist;
    }

//    public function getName() {
//        return $this->_name;
//    }
//
//    public function setName($name) {
//        $this->_name = $name;
//    }

    public function bookOnline($numer, $id_goscia, $od_kiedy, $do_kiedy) {
        $expr = oci_parse($this->_this_conn, "begin HOTEL.BOOKONLINE(:numer,:id_goscia,:od_kiedy,:do_kiedy); end;");
        oci_bind_by_name($expr, ":numer", $numer, -1);
        oci_bind_by_name($expr, ":id_goscia", $id_goscia, -1);
        oci_bind_by_name($expr, ":od_kiedy", $od_kiedy, -1);
        oci_bind_by_name($expr, ":do_kiedy", $do_kiedy, -1);
        $check = oci_execute($expr);
        if ($check == true)
            $commit = oci_commit($this->_this_conn);
        else
            $commit = oci_rollback($this->_this_conn);
        oci_free_statement($expr);
    }

    public function modifyBooking() {
        
    }

    public function cancelBooking($id) {
        $expr = oci_parse($this->_this_conn, "declare isReservationIdExist NUMBER:=0; begin HOTEL.CANCELBOOKING(:id); end;");
        oci_bind_by_name($expr, ":isReservationIdExist", $isReservationIdExist);
        oci_bind_by_name($expr, ":id", $id, -1);
        $check = oci_execute($expr);
        if ($check == true)
            $commit = oci_commit($this->_this_conn);
        else
            $commit = oci_rollback($this->_this_conn);
        oci_free_statement($expr);
        return $isReservationIdExist;
    }

    public function __destruct() {
        oci_close($this->_this_conn);
    }

    public function __toString() {
        return "Obiekt klasy " . __CLASS__ . "";
    }

    public function getCardId() {
        return $this->_cardId;
    }

    public function setCardId($cardId) {
        if (ereg('[0-9]+$', $cardId)) {
            $lenght = strlen($cardId);
            //if ($passwordLenght >= 6 && $passwordLenght <= 40) {
            if ($lenght == 16) {
                $this->_cardId = $cardId;
            } else {
                echo '<p>Numer karty musi posiadać 16 znaków.</p>';
                //throw new Exception("<p>Hasło musi posiadać od 8 do 40 znaków.</p>");
            }
        } else {
            echo '<p>W numerze karty muszą znajdować się tylko cyfry.</p>';
        }
    }

    private $_cardId;
//protected $_conn;
    private $_this_conn;

    //private $obj = new HotelGuest();
}

?>
