<html xmlns = "http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
                <div id="formArea">
                    <form id="login-form" action="index.php" method="POST">
                        <fieldset class="centered">
                            <h2 class="underline extraBottomMargin">Zaloguj się do<br /> Hotel & Restaurant</h2>

                            <table>
                                <tr>
                                    <td><label>Nazwa klienta</label></td>		
                                    <td><input type="text" name="login" /></td>             
                                </tr>
                                <tr>
                                    <td><label>Hasło</label></td>
                                    <td><input type="password" name="haslo" /></td>
                                </tr>
                            </table>
                            <div class="row">
                                <a href="renew_password.php" class="renewPasswordLink">Nie pamiętasz hasła?</a>
                            </div>
                            <div class="row submit">
                                <input type="submit" value="Zaloguj się" class="button gradient_gold" />
                            </div>
                            <div class="row rememberMe">

                            </div>
                        </fieldset>
                    </form>
                    <div id="registrationArea">
                        <h2>Nie masz jeszcze konta?</h2>
                        <a href="register.php" class="button gradient_silver">
                            <span>Zarejestruj się</span>
                        </a>
                        <div id="registrationBenefits" class="lessmargin">
                            <h2>Dzięki rejestracji będziesz mógł za darmo:</h2>
                            <ul>
                                <li><p>Dokonywać rezerwacji online.</p></li>
                                <li><p>Anulować rezerwację do godziny 18:00.</p></li>
                                <li><p>Otrzymywać powiadomienia o zniżkach na swojego e-maila.</p></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="footer footer_registration">
                <div class="wrap">
                    <p><span class="bold">Hotel & Restaurant</span> <span class="splitter">&nbsp;|&nbsp;</span>
                        <a href="#">Najczęściej zadawane pytania</a><span class="splitter">&nbsp;|&nbsp;</span>
                        <a href="#">Regulamin rezerwacji</a><span class="splitter">&nbsp;|&nbsp;</span>
                        <a href="#">Kontakt</a></p>
                    <p style="width: 200px;float: right">Webdesign: 8SOFT © 2013</p>
                </div>
            </div>
    </body>
</html>






