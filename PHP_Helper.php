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
            //$r['LAZIENKA'];
        }//bez tej petli nie dziala oci_num_rows
        $rowsCount = oci_num_rows($expr);
        oci_close($conn);
        return $rowsCount;
    }

    static function stripFormsSlashes($value) {
        if (get_magic_quotes_gpc()) {
            $value = stripslashes($value);
        }
    }

    static function saltyhash($pass) {

        // Define hash types
        $passmd5 = md5($pass);
        $passsha1 = sha1($pass);

        // Break up md5
        $md500 = substr($passmd5, 0, 1);
        $md501 = substr($passmd5, 1, 1);
        $md502 = substr($passmd5, 2, 1);
        $md503 = substr($passmd5, 3, 1);
        $md504 = substr($passmd5, 4, 1);
        $md505 = substr($passmd5, 5, 1);
        $md506 = substr($passmd5, 6, 1);
        $md507 = substr($passmd5, 7, 1);
        $md508 = substr($passmd5, 8, 1);
        $md509 = substr($passmd5, 9, 1);
        $md510 = substr($passmd5, 10, 1);
        $md511 = substr($passmd5, 11, 1);
        $md512 = substr($passmd5, 12, 1);
        $md513 = substr($passmd5, 13, 1);
        $md514 = substr($passmd5, 14, 1);
        $md515 = substr($passmd5, 15, 1);
        $md516 = substr($passmd5, 16, 1);
        $md517 = substr($passmd5, 17, 1);
        $md518 = substr($passmd5, 18, 1);
        $md519 = substr($passmd5, 19, 1);
        $md520 = substr($passmd5, 20, 1);
        $md521 = substr($passmd5, 21, 1);
        $md522 = substr($passmd5, 22, 1);
        $md523 = substr($passmd5, 23, 1);
        $md524 = substr($passmd5, 24, 1);
        $md525 = substr($passmd5, 25, 1);
        $md526 = substr($passmd5, 26, 1);
        $md527 = substr($passmd5, 27, 1);
        $md528 = substr($passmd5, 28, 1);
        $md529 = substr($passmd5, 29, 1);
        $md530 = substr($passmd5, 30, 1);
        $md531 = substr($passmd5, 31, 1);
        $md532 = substr($passmd5, 32, 1);

        // Break up sha1
        $sha100 = substr($passsha1, 0, 1);
        $sha101 = substr($passsha1, 1, 1);
        $sha102 = substr($passsha1, 2, 1);
        $sha103 = substr($passsha1, 3, 1);
        $sha104 = substr($passsha1, 4, 1);
        $sha105 = substr($passsha1, 5, 1);
        $sha106 = substr($passsha1, 6, 1);
        $sha107 = substr($passsha1, 7, 1);
        $sha108 = substr($passsha1, 8, 1);
        $sha109 = substr($passsha1, 9, 1);
        $sha110 = substr($passsha1, 10, 1);
        $sha111 = substr($passsha1, 11, 1);
        $sha112 = substr($passsha1, 12, 1);
        $sha113 = substr($passsha1, 13, 1);
        $sha114 = substr($passsha1, 14, 1);
        $sha115 = substr($passsha1, 15, 1);
        $sha116 = substr($passsha1, 16, 1);
        $sha117 = substr($passsha1, 17, 1);
        $sha118 = substr($passsha1, 18, 1);
        $sha119 = substr($passsha1, 19, 1);
        $sha120 = substr($passsha1, 20, 1);
        $sha121 = substr($passsha1, 21, 1);
        $sha122 = substr($passsha1, 22, 1);
        $sha123 = substr($passsha1, 23, 1);
        $sha124 = substr($passsha1, 24, 1);
        $sha125 = substr($passsha1, 25, 1);
        $sha126 = substr($passsha1, 26, 1);
        $sha127 = substr($passsha1, 27, 1);
        $sha128 = substr($passsha1, 28, 1);
        $sha129 = substr($passsha1, 29, 1);
        $sha130 = substr($passsha1, 30, 1);
        $sha131 = substr($passsha1, 31, 1);
        $sha132 = substr($passsha1, 32, 1);
        $sha133 = substr($passsha1, 33, 1);
        $sha134 = substr($passsha1, 34, 1);
        $sha135 = substr($passsha1, 35, 1);
        $sha136 = substr($passsha1, 36, 1);
        $sha137 = substr($passsha1, 37, 1);
        $sha138 = substr($passsha1, 38, 1);
        $sha139 = substr($passsha1, 39, 1);
        $sha140 = substr($passsha1, 40, 1);

        // Stich md5 and sha1 back together
        $saltyhash = $md500 . $sha100 . $md501 . $sha101 . $md502 . $sha102 . $md503 . $sha103 . $md504 . $sha104 . $md505 . $sha105 . $md506 . $sha106 . $md507 . $sha107 . $md508 . $sha108 . $md509 . $sha109 . $md510 . $sha110 . $md511 . $sha111 . $md512 . $sha112 . $md513 . $sha113 . $md514 . $sha114 . $md515 . $sha115 . $md516 . $sha116 . $md517 . $sha117 . $md518 . $sha118 . $md519 . $sha119 . $md520 . $sha120 . $md521 . $sha121 . $md522 . $sha122 . $md523 . $sha123 . $md524 . $sha124 . $md525 . $sha125 . $md526 . $sha126 . $md527 . $sha127 . $md528 . $sha128 . $md529 . $sha129 . $md530 . $sha130 . $md531 . $sha131 . $md532 . $sha132 . $sha133 . $sha134 . $sha135 . $sha136 . $sha137 . $sha138 . $sha139 . $sha140;

        return $saltyhash;
    }

    const TEXT_PATTERN = '/^[a-zA-Z]+$/';
    const NUMBER_PATTERN = '/^[0-9]+$/';

//    static final $text_pattern = '[a-zA-Z]+$';
}

?>
