<html xmlns = "http://www.w3.org/1999/xhtml">
    <head>
        <?php
        include('createHead.php');
        createHead("H&R - Rejestracja");
        ?>
    </head>
    <body>
        <?php
        error_reporting(E_ALL);
        include('navigation.php');
        ?>
        <div class="wrap">
            <div id="content" style="margin: 20px;">
                <?php

                function showRegistrationForm() { ?>
                    <div style="clear:both">
                        <h2 class="underline">Formularz rejestracji</h2>
                        <form action="register.php" method="POST">
                            <table>
                                <tr><td>Imię (*)</td><td><input type="text" name="imie" ></td></tr>
                                <tr><td>Nazwisko (*)</td><td><input type="text" name="nazwisko" ></td></tr>
                                <tr><td>Login (*)</td><td><input type="text" name="login"></td></tr>
                                <tr><td>Hasło (*)</td><td><input type="password" name="haslo"></td></tr>
                                <tr><td>Nr karty (opcjonalnie)</td><td><input type="text" name="nr_karty"></td> </tr>
                                <tr><td></td><td><input type="submit" class="button gradient_gold"></td> </tr>
                            </table>
                        </form>
                    </div>
                <?php } ?>
                <?php
                include('PHP_Helper.php');
                include('Users/User.php');
                include('Users/HotelGuest.php');

                if (!isset($_POST['imie']) ||
                        !isset($_POST['nazwisko']) ||
                        !isset($_POST['login']) ||
                        !isset($_POST['haslo']))
                    showRegistrationForm();
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (empty($_POST['imie']) ||
                            empty($_POST['nazwisko']) ||
                            empty($_POST['login']) ||
                            empty($_POST['haslo'])) {
                        echo '<p class = "error_text" style = "border: 1px solid #ccc;">Uzupełnij niezbędne pola.</p>';
                        showRegistrationForm();
                    } else {
                        $imie = $_POST['imie'];
                        $nazwisko = $_POST['nazwisko'];
                        $login = $_POST['login'];
                        //echo $login;
                        //$haslo = sha1($_POST['haslo']);
                        $haslo = $_POST['haslo'];
                        $nr_karty = $_POST['nr_karty'];
                        $hotelGuest = new HotelGuest($imie, $nazwisko, $login, $haslo, $nr_karty);
                        $isLoginExist = $hotelGuest->addUser();

                        if ($isLoginExist == 0) {
                            ?>
                            <h2 class="ok_text">Rejestracja przebiegła pomyślnie</h2>
                            <p><a href="index.php">Przejdź do strony głównej</a></p>
                        <?php } else if ($isLoginExist == 1) { ?>
                            <p class="error_text">Użytkownik o podanej nazwie już istnieje</p>
                               <br /><!--<p><a href="register.php">Przejdź do formularza rejsestracji</a></p>-->
                            <?php
                            showRegistrationForm();
                        }
                    }
                }
                ?>

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