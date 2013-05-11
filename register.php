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
        //include('header.php');

        include('navigation.php');
        ?>

        <div class="wrap">
            <div id="content" style="margin: 20px;">
                <h2 class="underline">Formularz rejestracji</h2>
                <form action="register_summary.php" method="POST">
                    <table>
                        <tr><td>Imię</td><td><input type="text" name="imie" ></td></tr>
                        <tr><td>Nazwisko</td><td><input type="text" name="nazwisko" ></td></tr>
                        <tr><td>Login</td><td><input type="text" name="login"></td></tr>
                        <tr><td>Hasło</td><td><input type="password" name="haslo"></td></tr>
                        <tr><td>Nr karty (opcjonalnie)</td><td><input type="text" name="nr_karty"></td> </tr>
                        <tr><td></td><td><input type="submit" class="button gradient_gold"></td> </tr>
                    </table>
                </form>
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