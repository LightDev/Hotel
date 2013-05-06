<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <title>Hotel & Restaurant</title>
            <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
            <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
            <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
            <script src="js/jsHelper.js"></script>
            <!--<link rel="stylesheet" href="css/StyleSheet1.css" />-->
            <script>
//                function logout() {
//                    $.get("logout.php");
//                    return false;
//                }
            </script>
            <style type="text/css">
                @import url('css/main_css.css');
            </style>
    </head>

    <body>
        <?php
        error_reporting(E_ALL);

        function showLoginForm() {
            ?>
            <form action = "index.php" method="POST">
                Nr klienta: <input name="login" type="text" /> Hasło: <input name="haslo" type="password" />
                <input type = "submit" class = "button gradient_gold" value = "Zaloguj się" />
                <a href = "#" class = "button gradient_silver">Rejestracja</a>
            </form>
            <?php
        }

//        $uzytkownicy = array(1 =>
//            array('login' => 'u1', 'haslo' => sha1('pp')),
//            array('login' => 'nlight', 'haslo' => sha1('a')),
//            array('login' => 'user3', 'haslo' => sha1('fff'))
//        );

        function czyIstnieje($login, $haslo) {
            echo 'haslo z forma ' . $haslo . "<br>";
            $haslo = sha1(trim($haslo));
            echo 'loginz forma ' . $login . "<br>";
            echo 'haslo z forma ' . $haslo . "<br>";

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
            if ($rowsCount == 1) {
                if ($loginZBazy == $login && $hasloZBazy == $haslo) {
                    return $id;
                }
            }
            return false;
        }

        session_start();
        if (!isset($_SESSION['uzytkownik'])) {
            // Sesja się zaczyna, wiec inicjujemy użytkownika anonimowego
            $_SESSION['uzytkownik'] = 0;
        }
        ?>
        <div id="header">
            <div class="wrap">
                <!--                <div class="logo">
                                    <a href="#">Logo Of Your Site!</a>
                                </div>-->
                <div id="loginButtons" style="width:150px;">

                    <?php
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
                                echo 'Podałeś nieprawidłowe login lub hasło';
                                showLoginForm();
                            }
                        } else {
                            showLoginForm();
                        }
                    }
                    ?>
                </div>
                <!--<p>This site is amazing!</p>-->
            </div>
        </div>
        <div id="navigation">
            <div class="wrap">
                <ul>
                           <!--<img src="img/logo.png" style="color:#D5AA65;"/>-->
                    <li><a href="#" style="margin-top: 10px;color:#D5AA65;font-weight: bold;font-size: 23px;">Hotel & Restaurant</a></li>
                    <li><a href="#" >POKOJE</a></li>
                    <li><a href="#" >RESTAURACJA</a></li>
                    <li><a href="#" >KONFERENCJE</a></li>
                    <li><a href="#" >OFERTA SPECJALNA</a></li>
                    <li><a href="#" >PROMOCJE</a></li>
                </ul>
            </div>
        </div>


        <div class="wrap">
            <div id="content" >
                <form action="reservation_results.php">
                    <div id="reservationPanel" >
                        <div class="panel " style="width: 200px;" >
                            <h2 class="underline">Wybierz liczbę pokoi</h2>
                            <p >
                                <select class="aligncenter" name="jezyk" size="1" >
                                    <option>1 pokój</option>
                                    <option>2 pokoje</option>
                                    <option>3 pokoje</option>
                                    <option>4 pokoje</option>
                                </select>
                            </p>
                            <p class="circle" >1</p>
                            <!--<div class="circle">1</div>-->
                        </div>
                        <div class="panel" style="width: 400px;">
                            <h2 class="underline">Podaj czas pobytu</h2>
                            <p>Od:&nbsp;<input type="text" id="dateFrom" class="date_picker" />&nbsp;&nbsp;&nbsp;Do:&nbsp; <input type="text" id="dateTo" class="date_picker" /></p>
                            <p class="circle">2</p>
                        </div>

                        <div 
                            class="panel" 
                            style="width: 170px;padding-top: 20px;line-height: 10px;">
                            <p>
                                <!--<a href="#" class="button buttonSpecialPadding gradient_gold">Sprawdź dostępność</a>-->
                                <input type="submit" class="button buttonSpecialPadding gradient_gold" value="Sprawdź dostępność">
                            </p>
                            <p class="circle">3</p>
                        </div>
                </form>
            </div>
            <div id="otherOptionsPanel" >
                <span class="bold">Inne opcje:</span>
                <a href="#" >Wyszukiwanie zaawansowane</a>
                <a href="#" id="cancelReservationLink" >Anuluj rezerwację</a>
            </div>
            <div id="cancelReservationPanel" style="background: #666;border-top: none;">
                <form action="#">
                    Podaj numer rezerwacji: <input id="reservation_id" type="text" />
                    <!--<a href="#" class="button gradient_silver">Anuluj</a>-->
                    <input type="submit" value="Anuluj" class="button gradient_silver" />
                    <span class="error_text">Nie podałeś numeru rezerwacji</span>
                </form>
            </div>
            <!--<div id="wrapper">-->
            <div  class="panel">
                <h2 class="underline">INFORMACJE</h2>
                <table>
                    <tr>
                        <td><p><span class="bold">Anulowanie rezerwacji:</span> </p>
                        </td>
                        <td>do 18:00</td>
                    </tr>
                    <tr>
                        <td><span class="bold">Palenie:</span></td>
                        <td>Dozwolone</td>
                    </tr>
                    <tr>
                        <td><span class="bold">Zwierzęta:</span></td>
                        <td>Dozwolone</td>
                    </tr>
                    <tr>
                        <td>Depozyt:</td>
                        <td>100zł (Brak refundacji)</td>
                    </tr>
                    <tr>
                        <td>Opieka nad zwierzęciem:</td>
                        <td>TAK</td>
                    </tr>
                    <tr>
                        <td><span class="bold">Parking:</span></td>
                        <td>80 miejsc</td>
                        <tr>
                            <td>Normalny:</td>
                            <td>100zł</td>
                        </tr>
                        <tr>

                            <td>Z parkingowym:</td>
                            <td>120zł</td>
                        </tr>
                    </tr>
                </table>

                <p style="text-align: right">
                    <a href="#" >Więcej szczegółów</a>
                </p>
            </div>
            <div class="panel">
                <h2 class="underline">SPRAWDŹ DOJAZD</h2>
<!--<iframe src="http://www.map-generator.org/c367a213-aac7-4bcc-956d-60d9b2c9fdcf/iframe-map.aspx" scrolling="no" height="200px" width="280px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>                   <p>sadsadd</p>-->
                <div id="zumiMap" class="zumi_creator" style="width:280px; height:280px;"></div><script src="http://api.zumi.pl/maps/api" type="text/javascript" ></script><script type="text/javascript">(function() {
                        var marker, map = new zumi.maps.Map("zumiMap", {"apiKey": "DB85F8EBA7EB0780E0434628AE0AA164"});
                        map.afterLoad(function() {
                            document.getElementById("zumiMap").className += " zumi_creator";
                            marker = map.addMarker({lat: 53.117026, lng: 23.144629}, {letter: "A", type: "main"});
                            marker.bindPopup('<h2 class="title">Hotel & Restaurant</h2><span class="adress">Bia\u0142ystok</span><span class="adress">Wiejska 45C</span><span class="phone">983-345-234</span><span class="mail"><a href="mailto:"></a></span><p class="description"></p><div class="lastLinks"><a class="directions" target="_blank" href="http://www.zumi.pl/firmy,23.144629:53.117026,1,7,namapie.html">w okolicy</a><span class="separate">|</span><a class="directions" target="_blank" href="http://www.zumi.pl/,23.144629:53.117026,1,23.144629,53.117026,1,12,trasa.html">dojazd</a></div>', {minWidth: 192});
                            marker.openPopup();
                            map.setCenter({lng: 23.144629, lat: 53.117026}, 8);
                        });
                    })();</script>
            </div>
            <div class="panel">
                <h2 class="underline">AKTUALNA POGODA</h2>
                <p>20 Białystok</p>
            </div>
        </div>
        </div>
        <!--</div>-->
        <!--</div>-->

        <div id="footer">
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