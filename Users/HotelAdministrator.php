<?php

class HotelAdministrator extends User {

    public function __construct() {
        $this->_this_conn = PHP_Helper::getConnection(); //parent::_conn;
    }

//    public function addRoom($) {
//        
//    }

    public function deleteRoom($id) {
        $zapytanie = "DELETE FROM Pokoje WHERE numer=:id";
        $wyrazenie = oci_parse($this->_this_conn, $zapytanie);
        oci_bind_by_name($wyrazenie, ":id", $id, -1);

        if (!oci_execute($wyrazenie)) {
            $err = oci_error($wyrazenie);
            trigger_error('Zapytanie zakoĹ?czyĹ?o siÄ? niepowodzeniem: ' . $err ['message'], E_USER_ERROR);
        }
        oci_close($polaczenie);
        return true;
    }

    public function deleteEmp($id) {
        $zapytanie = "DELETE FROM obsluga WHERE numer=:id";
        $wyrazenie = oci_parse($this->_this_conn, $zapytanie);
        oci_bind_by_name($wyrazenie, ":id", $id, -1);

        if (!oci_execute($wyrazenie)) {
            $err = oci_error($wyrazenie);
            trigger_error('Zapytanie zakoĹ?czyĹ?o siÄ? niepowodzeniem: ' . $err ['message'], E_USER_ERROR);
        }
        oci_close($polaczenie);
        return true;
    }

    public $salary;

}
?>
