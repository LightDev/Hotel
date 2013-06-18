<?php
session_start();

function czyIstnieje($login, $haslo) {
//    echo 'haslo z forma ' . $haslo . "<br>";
    $haslo = sha1(trim($haslo));
//    echo 'loginz forma ' . $login . "<br>";
//    echo 'haslo z forma ' . $haslo . "<br>";

    $zapytanie = "select id,login, haslo from " . (($_SESSION['typ'] == "worker") ? "obsluga" : "administratorzy") . " where login='" . trim($login) . "'";
    $polaczenie = oci_connect("hotel", "hotel", "localhost/XE");
    $wyrazenie = oci_parse($polaczenie, $zapytanie);
    if (!oci_execute($wyrazenie)) {
        $err = oci_error($wyrazenie);
        trigger_error('Zapytanie zakończyło się niepowodzeniem: ' . $err ['message'], E_USER_ERROR);
    }
    $id = 0;
    $loginZBazy = "a";
    $hasloZBazy = "a";
    while ($rekord = oci_fetch_array($wyrazenie, OCI_BOTH)) {
        $id = $rekord['ID'];
        $loginZBazy = $rekord['LOGIN'];
        $hasloZBazy = $rekord['HASLO'];
    }//bez tej petli nie dziala oci_num_rows
    $rowsCount = oci_num_rows($wyrazenie);
//    echo 'rows ' . $rowsCount . "<br>";
//    echo 'id ' . $id . "<br>";
//    echo 'loginzbazy ' . $loginZBazy . "<br>";
//    echo 'haslozbazy ' . $hasloZBazy . "<br>";
    oci_close($polaczenie);
    if ($rowsCount == 1) { //co prawda w bazie ma zawsze istniec tylko jeden uzytkownik o podanym loginie jednak bezpieczenstwa nigdy zawiele
        if ($loginZBazy === $login && $hasloZBazy === $haslo) {
            return $id;
        }
    }
    return false;
}
?>
<div id="header">
    <div class="wrap">
        <?php
        if ($_SESSION['uzytkownik1'] > 0) {
            echo //'<a href="#">Moje rezerwacje</a>
            '<div id="loginButtons" style="width:150px;">Witaj ' . $_SESSION['login1'] .
            '<a href = "logout.php" class = "button gradient_silver">Wyloguj</a>';
            //'<a href = "index.php" onclick="logout();" class = "button gradient_silver">Wyloguj</a>';
        } else {
            //if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//            echo $_SESSION['login'] . "<br>";
//            echo $_SESSION['haslo'] . "<br>";
            if (($id = czyIstnieje($_SESSION['login1'], $_SESSION['haslo1'])) !== false) {
                $_SESSION['uzytkownik1'] = $id;
                //$_SESSION['login'] = $_POST['login'];
                echo //'<a href="#">Moje rezerwacje</a>
                '<div id="loginButtons" style="width:150px;">Witaj ' . $_SESSION['login1'] .
                '<a href = "logout.php" class = "button gradient_silver">Wyloguj</a>';
            } else {
//                echo '<div id="loginButtons" style="width:860px;"><span class = "error_text">Podałeś nieprawidłowe login lub hasło</span>';
//                showLoginForm();
                header('Location: login_panel.php');
            }
        }
        ?>
    </div>
</div>
</div>
