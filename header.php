<?php

function showLoginForm() { ?>
    <form action = "index.php" method="POST">
        Nr klienta: <input name="login" type="text" /> Hasło: <input name="haslo" type="password" />
        <input type = "submit" class = "button gradient_gold" value = "Zaloguj się" />
        <a href = "register.php" class = "button gradient_silver">Rejestracja</a>
    </form>
    <?php
}

function czyIstnieje($login, $haslo) {
//            echo 'haslo z forma ' . $haslo . "<br>";
    $haslo = sha1(trim($haslo));
//            echo 'loginz forma ' . $login . "<br>";
//            echo 'haslo z forma ' . $haslo . "<br>";

    $zapytanie = "select id,login, haslo from goscie where login='" . trim($login) . "'";
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
//            echo 'rows ' . $rowsCount . "<br>";
//            echo 'id ' . $id . "<br>";
//            echo 'loginzbazy ' . $loginZBazy . "<br>";
//            echo 'haslozbazy ' . $hasloZBazy . "<br>";
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
        <!--                <div class="logo">
                            <a href="#">Logo Of Your Site!</a>
                        </div>-->
        <div id="loginButtons">
            <?php
            session_start();
            if (!isset($_SESSION['uzytkownik'])) {
                // Sesja się zaczyna, wiec inicjujemy użytkownika anonimowego
                $_SESSION['uzytkownik'] = 0;
            }
            if ($_SESSION['uzytkownik'] > 0) {
                // Ktos jest zalogowany
                echo //'<a href="#">Moje rezerwacje</a>
                'Witaj ' . $_SESSION['login'] .
                '<a href = "logout.php" class = "button gradient_silver">Wyloguj</a>';
                //'<a href = "index.php" onclick="logout();" class = "button gradient_silver">Wyloguj</a>';
            } else {
                // Niezalogowany
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (($id = czyIstnieje($_POST['login'], $_POST['haslo'])) !== false) {
                        // Logujemy uzytkownika, wpisal poprawne dane
                        $_SESSION['uzytkownik'] = $id;
                        $_SESSION['uzytkownik'] = $_POST['login'];
                        //echo 'Witaj ' . $_POST['login'] . ' <a href = "#" class = "button gradient_silver">Wyloguj</a>';
                        echo //'<a href="#">Moje rezerwacje</a>
                        'Witaj ' . $_POST['login'] .
                        '<a href = "logout.php" class = "button gradient_silver">Wyloguj</a>';
                    } else {
                        echo '<p class = "error_text">Podałeś nieprawidłowe login lub hasło</p>';
                        //echo '<span class="error_text">Podałeś nieprawidłowe login lub hasło</span>';
                        showLoginForm();
                    }
                } else {
                    showLoginForm();
                }
            }
            ?>
        </div>
    </div>
</div>
