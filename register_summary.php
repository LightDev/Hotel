<html xmlns = "http://www.w3.org/1999/xhtml">
    <head>

        <?php
        include('PHP_Helper.php');
        include('createHead.php');
        createHead("H&R - Rejestracja");
        ?>
    </head>

    <body>
        <?php
        error_reporting(E_ALL);
        //include('header.php');

        include('navigation.php');
        include('Users/User.php');
        include('Users/HotelGuest.php');
        ?>
        <?php
//        $conn = PHP_Helper::getConnection();
        //$isLoginExist = false;
        $imie = $_POST['imie'];
        $nazwisko = $_POST['nazwisko'];
        $login = $_POST['login'];
        echo $login;
        //$haslo = sha1($_POST['haslo']);
        $haslo = $_POST['haslo'];
        $nr_karty = $_POST['nr_karty'];
        //$hotelGuest = new HotelGuest($imie, $nazwisko, $login, $haslo, $nr_karty);
        $hotelGuest = new HotelGuest($imie, $nazwisko, $login, $haslo, $nr_karty);
        //$hotelGuest = HotelGuest::HotelGuestSimple($imie, $nazwisko, $login, $haslo, $nr_karty);
        $isLoginExist = $hotelGuest->addUser();
        ?>
        <div class="wrap">
            <div id="content" style="margin: 20px;">
                <?php if ($isLoginExist == 0) { ?>
                    <h2 class="underline">Rejestracja przebiegła pomyślnie</h2>
                    <p><a href="index.php">Przejdź do strony głównej</a></p>
                <?php } else if ($isLoginExist == 1) { ?>
                    <h2 class="underline">Użytkownik o podanej nazwie już istnieje</h2>
                    <p><a href="register.php">Przejdź do formularza rejsestracji</a></p>
                <?php } ?>
            </div>
        </div>
        <div id="footer footer_registration">
            <div class="wrap">
                <p><span class="bold">Hotel & Restaurant</span> <span class="splitter">&nbsp;|&nbsp;</span>
                    <a href="#">Najczęściej zadawane pytania</a><span class="splitter">&nbsp;|&nbsp;</span>
                    <a href="#">Regulamin rezerwacji</a><span class="splitter">&nbsp;|&nbsp;</span>
                    <a href="#">Kontakt</a></p>
                <p style="width: 200px;float: right">Webdesign: 8SOFT &copy; 2013</p>
            </div>
        </div>

    </body>
</html>