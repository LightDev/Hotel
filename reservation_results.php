<html xmlns = "http://www.w3.org/1999/xhtml">
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <?php
        include('createHead.php');
        createHead("H&R - Rezerwacja pokoi");
        ?>
    </head>

    <body>
        <?php
        error_reporting(E_ALL);
        include('header.php');
        include('navigation.php');

        function showAvailableRooms($zapytanie, $dateFrom, $dateTo) {
            $polaczenie = oci_connect("hotel", "hotel", "localhost/XE");
            $wyrazenie = oci_parse($polaczenie, $zapytanie);
            if (!oci_execute($wyrazenie)) {
                $err = oci_error($wyrazenie);
                trigger_error('Zapytanie zakończyło się niepowodzeniem: ' . $err ['message'], E_USER_ERROR);
            }
            $i = 0;
            while ($rekord = oci_fetch_array($wyrazenie, OCI_ASSOC)) {
                echo '<div class="reservation_details">';
                echo '<table>';
                echo '<tr><h2 class="underline">Pokój nr: ' . $rekord['NUMER'] . '</h2></tr>';
                echo '<tr><td>' . (($i % 2 == 0) ? '<img src="img/YaBooking.jpg" />' : '<img src="img/room.jpg" />') . '</td>';
                echo '<td ><span style = "font-weight:bold;font-size:14px;">Opis</span><br>Ilość osób: ' . $rekord['ILU_OSOBOWY'] . '<br>';
                echo ($rekord['LAZIENKA'] == 'Y') ? 'Łazienka: ' . 'Tak' : 'Łazienka: ' . 'Nie' . '';
                echo '</td><td><span style = "font-size:18px;">CENA: ' . $rekord['CENA'] . ' zł</span>' . '</td>';

                echo '<td>';
//                echo '<div id = "" style = "">';
                if ($_SESSION['user'] > 0) {
                    echo '<form method = "POST" action = "reservation_summary.php?roomId=' . $rekord['NUMER'] . '">
                <input type = "submit" class = "button gradient_gold" value = "Sprawdź szczegóły" /></form>';
                } else {
                    echo '<a href = "loginOrRegister.php" class = "button gradient_gold">Sprawdź szczegóły</a>';
                }
//                echo '</td></tr>';
                echo '</td>';
                echo '</tr>';
                echo '</table>';
                echo '</div>';
                $i++;
                //echo '</div></div>';
            }
            oci_close($polaczenie);
        }
        ?>


        <div class="wrap">
            <div id="preferences_menu" >
                <h2 class="underline">Preferencje</h2>
                <?php
                $pok = $_POST['roomCount'];
                $laz = $_POST['lazienka'];
                ?>  <form action="reservation_results.php" method="POST">
                    Ilość pokoi:<br />

                    <input type="radio" name="roomCount" value="1" <?php echo ($pok[0] == '1') ? 'checked = "checked"' : "" ?> />1 pokój<br />
                    <input type="radio" name="roomCount" value="2" <?php echo ($pok[0] == '2') ? 'checked = "checked"' : "" ?> />2 pokoje<br />
                    <input type="radio" name="roomCount" value="3" <?php echo ($pok[0] == '3') ? 'checked = "checked"' : "" ?> />3 pokoje<br /><br />
                    Łazienka:<br />
                    <input type="radio" name="lazienka" value="Y" <?php echo ($laz == 'Y') ? 'checked = "checked"' : "" ?> />Tak<br />
                    <input type="radio" name="lazienka" value="N" <?php echo ($laz == 'N') ? 'checked = "checked"' : "" ?> />Nie<br />

                    <input type="submit"  value="Filtruj wyniki"  /><br />
                </form>
            </div>
            <div id="reservation_result" >
                <?php
                include('PHP_Helper.php');

//                if (!isset($_SESSION['dateFromHidden']) && !isset($_SESSION['dateToHidden'])) {
//                    $_SESSION['dateFromHidden'] = $_POST['dateFromHidden'];
//                    $_SESSION['dateToHidden'] = $_POST['dateToHidden'];
//                    $dateFrom = $_SESSION['dateFromHidden'];
//                    $dateTo = $_SESSION['dateToHidden'];
//                    //}
//                } else {
//                    $dateFrom = $_SESSION['dateFromHidden'];
//                    $dateTo = $_SESSION['dateToHidden'];
//                }
                if (!(isset($_POST['dateFromHidden']) || isset($_POST['dateToHidden']))) {
                    $dateFrom = $_SESSION['dateFromHidden'];
                    $dateTo = $_SESSION['dateToHidden'];
                } else {
                    $dateFrom = $_POST['dateFromHidden'];
                    $dateTo = $_POST['dateToHidden'];
                    $_SESSION['dateFromHidden'] = $dateFrom;
                    $_SESSION['dateToHidden'] = $dateTo;
                }
                echo '<h2 class="underline">Dostępne pokoje od ' . $dateFrom . ' do ' . $dateTo . '.</h2>';
//                echo "dateToHidden" . $_POST['dateToHidden'] . "<br>";
//                echo "dateToHiddenSESSION" . $_SESSION['dateToHidden'] . "<br>";
//                echo $dateFrom . "<br>";
//                echo "dateFROMHiddenSESSION" . $_SESSION['dateFromHidden'] . "<br>";

                $roomCount = $_POST['roomCount'];
                //echo "roomCount" . $roomCount . "<br>";
                $lazienka = $_POST['lazienka'];
                //echo "lazienka " . $lazienka . "<br>";
                ///$lazienka = (($lazienka == "Y") ? 'Y' : 'N');
                //echo "lazienka " . $lazienka . "<br>";

                $zapytanie = "SELECT distinct p.numer,p.ilu_osobowy,p.cena,p.lazienka, od_kiedy,do_kiedy 
FROM Rezerwacje r, Pokoje p  
WHERE (p.numer=r.numer(+)) and lazienka='{$lazienka}' and ilu_osobowy={$roomCount[0]} 
MINUS 
SELECT distinct p.numer,p.ilu_osobowy,p.cena,p.lazienka,od_kiedy,do_kiedy  
FROM Rezerwacje r JOIN Pokoje p ON(r.numer=p.numer) 
WHERE 
sysdate > od_kiedy and sysdate < do_kiedy 
MINUS 
SELECT distinct p.numer,p.ilu_osobowy,p.cena,p.lazienka,od_kiedy,do_kiedy  
FROM Rezerwacje r JOIN Pokoje p ON(r.numer=p.numer) 
WHERE 
r.od_kiedy  between to_date(' {$dateFrom}','yyyy/mm/dd') and to_date(' {$dateTo}','yyyy/mm/dd') or 
 r.do_kiedy  between to_date(' {$dateFrom}','yyyy/mm/dd') and to_date(' {$dateTo}','yyyy/mm/dd')
order by 1";
//
                // var_dump($zapytanie);
//                if (PHP_Helper::getCount($zapytanie) == 0)
//                    echo 'Niestety wszystkie pokoje są zajęte w danym terminie.';
//                else {
                showAvailableRooms($zapytanie, $dateFrom, $dateTo);
//                }
                //}
                ?>
            </div>
        </div>
        <?php include('footer.php'); ?>
    </body>
</html>