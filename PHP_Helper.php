<?php

class PHP_Helper {

    static function getConnection() {
        $login = "hotel";
        $password = "hotel";
        $c = oci_connect($login, $password, "localhost/XE");
        if (!$c) {
            echo "Unable to connect: " . var_dump(oci_error());
            die();
        }
        return $c;
    }

    static function getCount($query) {

        $conn = oci_connect("hotel", "hotel", "localhost/XE");
        $expr = oci_parse($conn, $query);
        if (!oci_execute($expr)) {
            $err = oci_error($expr);
            trigger_error('Zapytanie zakończyło się niepowodzeniem: ' . $err ['message'], E_USER_ERROR);
        }
        while ($r = oci_fetch_array($expr, OCI_ASSOC)) {
            $r['LAZIENKA'];
        }//bez tej petli nie dziala oci_num_rows
        $rowsCount = oci_num_rows($expr);
        oci_close($conn);
        return $rowsCount;
    }

}

?>
