<html xmlns = "http://www.w3.org/1999/xhtml">
    <head>

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
            while ($rekord = oci_fetch_array($wyrazenie, OCI_ASSOC)) {
                echo '<div style="border-bottom:1px solid #eee;">';
                echo '<h2 class="underline">Pokój nr: ' . $rekord['NUMER'] . '</h2>';
                echo '<table>';
                echo '<tr><td>Ilość osób: ' . $rekord['ILU_OSOBOWY'] . '</td>';
                echo ($rekord['LAZIENKA'] == 'Y') ? '<td>Łazienka: ' . 'Tak' : 'Łazienka: ' . 'Nie' . '</td>';
                echo '<td>CENA: ' . $rekord['CENA'] . ' zł' . '</td>';
//                if ($_SESSION['user'] > 0) {
//                    echo '<td><a href = "reservation_summary.php?roomId=' . $rekord['NUMER'] . '" class = "button gradient_gold">Dokonaj rezerwacji</a></td>';
//                } else {
//                    echo '<td><a href = "register.php" class = "button gradient_gold">Dokonaj rezerwacji</a></td>';
//                }
                echo '</tr></table>';
                if ($_SESSION['user'] > 0) {
                    echo '<div id="" style="width:200px;float:right;">
                        <form method="POST" action= "reservation_summary.php?roomId=' . $rekord['NUMER'] . '">
                            <input type="submit" class = "button gradient_gold" value="Sprawdź szczegóły" />
                            
                                        </form>
                          </div>';
                } else {
                    echo '<a href = "loginOrRegister.php" class = "button gradient_gold">Sprawdź szczegóły</a>';
                }
                echo '</div>';
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

                    <input type="radio" name="roomCount" value="1" <?php echo ($pok[0] == '1') ? 'checked="checked"' : "" ?> />1 pokój<br />
                    <input type="radio" name="roomCount" value="2" <?php echo ($pok[0] == '2') ? 'checked="checked"' : "" ?> />2 pokoje<br />
                    <input type="radio" name="roomCount" value="3" <?php echo ($pok[0] == '3') ? 'checked="checked"' : "" ?> />3 pokoje<br /><br />
                    Łazienka:<br />
                    <input type="radio" name="lazienka" value="Y" <?php echo ($laz == 'Y') ? 'checked="checked"' : "" ?> />Tak<br />
                    <input type="radio" name="lazienka" value="N" <?php echo ($laz == 'N') ? 'checked="checked"' : "" ?> />Nie<br />

                    <input type="submit"  value="Filtruj wyniki"  /><br />
                </form>
            </div>
            <div id="reservation_result" >
                <h2 class="underline">Dostępne pokoje</h2>
                <?php
                include('PHP_Helper.php');

                if (!isset($_SESSION['dateFromHidden']) && !isset($_SESSION['dateToHidden'])) {
                    $_SESSION['dateFromHidden'] = $_POST['dateFromHidden'];
                    $_SESSION['dateToHidden'] = $_POST['dateToHidden'];
                    $dateFrom = $_SESSION['dateFromHidden'];
                    $dateTo = $_SESSION['dateToHidden'];
                    //}
                } else {
                    $dateFrom = $_SESSION['dateFromHidden'];
                    $dateTo = $_SESSION['dateToHidden'];
                }
                //echo "dateToHidden" . $_POST['dateToHidden'] . "<br>";
                //echo "dateToHiddenSESSION" . $_SESSION['dateToHidden'] . "<br>";
                //echo $dateFrom . "<br>";

                $roomCount = $_POST['roomCount'];
                //echo "roomCount" . $roomCount . "<br>";
                $lazienka = $_POST['lazienka'];
                //echo "lazienka " . $lazienka . "<br>";
                //$lazienka = (($lazienka == "Y") ? 'Y' : 'N');
                //echo "lazienka " . $lazienka . "<br>";

                $zapytanie = "SELECT * FROM Rezerwacje r JOIN Pokoje p ON(r.numer=p.numer) 
                    WHERE (od_kiedy>to_date('" . $dateFrom . "','yyyy-mm-dd') AND od_kiedy>to_date('" . $dateTo . "','yyyy-mm-dd') OR
                        do_kiedy<to_date('" . $dateFrom . "','yyyy-mm-dd') AND do_kiedy<to_date('" . $dateTo . "','yyyy-mm-dd'))
                 ";
                $zapytanie = "SELECT distinct p.numer,p.ilu_osobowy,p.cena,p.lazienka,od_kiedy,do_kiedy 
FROM Rezerwacje r, Pokoje p  
WHERE (p.numer=r.numer(+))
MINUS
SELECT distinct p.numer,p.ilu_osobowy,p.cena,p.lazienka,od_kiedy,do_kiedy  
FROM Rezerwacje r JOIN Pokoje p ON(r.numer=p.numer) 
WHERE 
/*sysdate >od_kiedy */
sysdate > od_kiedy and sysdate < do_kiedy

MINUS
SELECT distinct p.numer,p.ilu_osobowy,p.cena,p.lazienka,od_kiedy,do_kiedy  
FROM Rezerwacje r JOIN Pokoje p ON(r.numer=p.numer) 
WHERE 
r.od_kiedy  between to_date('13/06/14','yy/mm/dd') and to_date('13/06/17','yy/mm/dd') or
 r.do_kiedy  between to_date('13/06/14','yy/mm/dd') and to_date('13/06/17','yy/mm/dd')
order by 1; 
";

                //var_dump($zapytanie);
                if (PHP_Helper::getCount($zapytanie) == 0)
                    echo 'Niestety wszystkie pokoje są zajęte w danym terminie.';
                else {
                    showAvailableRooms($zapytanie, $dateFrom, $dateTo);
                }
                //}
                ?>
            </div>
        </div>
        <?php include('footer.php'); ?>
    </body>
</html>