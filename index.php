<!doctype html>
<?php
/*
  1. DONE Nastepuje autom wylogowanie jesli zmodyfikujemy adres dodajac np ? lub #
  2.      Nalezy zabezpieczyc kalendarze aby nie mozna bylo zaznaczyc daty wstecz
  3.      Procedura registerUser w pakiecie hotel
  4.      Filtrowanie wyboru pokoju
  5.      Zabezpieczyc anulowanie rezerwacji
 */
?>
<html xmlns = "http://www.w3.org/1999/xhtml">
    <head>
        <?php
        include('createHead.php');
        createHead("Hotel & Restaurant");
        ?>
    </head>

    <body>
        <?php
        error_reporting(E_ALL);
        include('header.php');
        include('navigation.php');
        ?>
        <noscript>
            <h3>JavaScript is disabled! Why you want to do so? 
                Please enable JavaScript in your web browser!</h3>

            <style type="text/css">
                #main-content { display:none; }
            </style>
        </noscript>

        <!--        <div id="main-content">
                    <h3>Welcome, JavaScript user, i like web browser with JavaScript enabled!</h3>
                </div>-->
        <div class="wrap">
            <div id="content" >
                <form action="reservation_results.php" id="reservationForm" name="reservationForm" method="POST">
                    <div id="reservationPanel" >
                        <div class="panel" style="width: 200px;" >
                            <h2 class="underline">Wybierz liczbę pokoi</h2>
                            <p >
                                <select class="aligncenter" name="roomCount" size="1" >
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
                            <p>Od:&nbsp;<input type="text" name="dateFrom" id="dateFrom" class="date_picker" />&nbsp;&nbsp;&nbsp;Do:&nbsp;
                                <input type="text" name="dateTo" id="dateTo" class="date_picker" /></p>
                            <p class="circle">2</p>
                        </div>

                        <div
                            class="panel"
                            style="width: 170px;padding-top: 20px;line-height: 10px;">
                            <p>
                                <!--<a href="#" class="button buttonSpecialPadding gradient_gold">Sprawdź dostępność</a>-->
                                <!--<input type="submit" class="button buttonSpecialPadding gradient_gold" value="Sprawdź dostępność">-->
                                <input type="hidden" name="dateFromHidden" id="dateFromHidden" value=""  >
                                    <input type="hidden" name="dateToHidden" id="dateToHidden" value=""  >
                                        <a href="#" id="resevationSubmit"  class="button buttonSpecialPadding gradient_gold">Sprawdź dostępność</a>
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
                                                <span class="error_text no_display">Nie podałeś numeru rezerwacji</span>
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
                                        <?php include('footer.php'); ?>
                                        </body>
                                        </html>