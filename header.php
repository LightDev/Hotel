<?php
session_start();

//include('PHP_Helper.php');

function showLoginForm() {
    ?>
    <form action = "index.php" method="POST">
        Nazwa klienta: <input name="login" type="text" /> Hasło: <input name="haslo" type="text" />
        <input type = "submit" class = "button gradient_gold" value = "Zaloguj się" />
        <a href = "register.php" class = "button gradient_silver">Rejestracja</a>
    </form>
    <?php
}

function czyIstnieje($login, $haslo) {
    $haslo = sha1(trim($haslo));
    $login = trim($login);

    $zapytanie = "select id,login, haslo from goscie where login='{$login}' AND haslo='{$haslo}'";
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
//    echo '$_SESSION[user] ' . $_SESSION['user'] . "<br>";

    oci_close($polaczenie);
    if ($rowsCount == 1) { //co prawda w bazie ma zawsze istniec tylko jeden user o podanym loginie jednak bezpieczenstwa nigdy zawiele
        if ($loginZBazy === $login && $hasloZBazy === $haslo) {
            return $id;
        }
    }
    return false;
}
?>
<div id="header">
    <div class="wrap">
        <!--        <div class="logo">
                    <a href="#">Logo Of Your Site!</a>
                </div>-->

        <?php
//        echo 'sha1:' . sha1('thisistesttext') . "<br>";
//        echo 'md5:' . md5('thisistesttext') . "<br>";
//        echo 'sha1:' . PHP_Helper::saltyhash('thisistesttext') . "<br>";
//        if (!isset($_SESSION['inicjuj'])) {
//            session_regenerate_id();
//            $_SESSION['inicjuj'] = true;
//            $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
//        }
//        if ($_SESSION['ip'] != $_SERVER['REMOTE_ADDR']) {
//            die('Proba przejecia sesji udaremniona!');
//        }
//        echo 'login z forma ' . $_POST['login'] . "<br>";
//        echo 'haslo z forma ' . $_POST['haslo'] . "<br>";

        if (!isset($_SESSION['user'])) {
            $_SESSION['user'] = 0;
        }
        if ($_SESSION['user'] == 0 && (!isset($_POST['login']) || !isset($_POST['haslo']))) {
            echo '<div id = "loginButtons">';
            showLoginForm();
        } else {
            if ($_SESSION['user'] > 0) {
                echo //'<a href = "#">Moje rezerwacje</a>
                '<div id="loginButtons" style="width:245px;">
                    <a href = "user_account.php" class="my_reservations_link" >Moje rezerwacje</a>
                            Witaj ' . $_SESSION['login'] .
                '<a href = "logout.php" class = "button gradient_silver">Wyloguj</a>';
//'<a href = "index.php" onclick="logout();" class = "button gradient_silver">Wyloguj</a>';
            } else {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (($id = czyIstnieje($_POST['login'], $_POST['haslo'])) !== false) {
                        $_SESSION['user'] = $id;
                        $_SESSION['login'] = $_POST['login'];
                        echo //'<a href="#">Moje rezerwacje</a>
                        '<div id="loginButtons" style="width:245px;">
                            <a href = "user_account.php" >Moje rezerwacje</a>
                            Witaj ' . $_POST['login'] .
                        '<a href = "logout.php" class = "button gradient_silver">Wyloguj</a>';
                    } else {
                        echo '<div id="loginButtons" style="width:860px;"><span class = "error_text">Podałeś nieprawidłowe login lub hasło</span>';
                        showLoginForm();
                    }
                } else {
                    echo '<div id="loginButtons">';
                    showLoginForm();
                }
            }
        }
        ?>
    </div>
</div>
</div>
