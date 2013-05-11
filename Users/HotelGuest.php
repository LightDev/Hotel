<?php

class HotelGuest extends User {

    public function __construct($name, $surname, $login, $password, $cardId) {
        parent::__construct($name, $surname, $login, $password);
        $this->_cardId = $cardId;
        //parent::setPassword($password);
        $this->_this_conn = PHP_Helper::getConnection(); //parent::_conn;
    }

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

    public function cancelReservation($id) {
        $expr = oci_parse($this->_this_conn, "declare isReservationIdExist NUMBER:=0; begin HOTEL.CANCELRESERVATION(:id); end;");
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

    private $_cardId;
    //protected $_conn;
    private $_this_conn;

}

?>
