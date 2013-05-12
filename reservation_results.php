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

        function showAvailableRooms($zapytanie) {
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
                            <input type="hidden" name="dateFromHidden" id="dateFromHidden" value="' . $_POST['dateFromHidden'] . '"  >
                                    <input type="hidden" name="dateToHidden" id="dateToHidden" value="' . $_POST['dateToHidden'] . '"  >
                                        </form>
                          </div>';
                } else {
                    echo '<a href = "loginOrRegister.php" class = "button gradient_gold">Sprawdź szczegóły</a>';
                }
                echo '</div>';
                //echo '<h2 class="underline"></h2>';
            }
            oci_close($polaczenie);


            echo "<div class = \"pager\">";
            echo '<ul>';
            $liczbaPrzedz = 3;
            for ($i = 0; $i < $liczbaPrzedz; $i++) {
                if ($liczbaPrzedz > 1) {
                    //if (($i + 1) == $_GET['page'] || (!isset($_GET['page']) && $i == 0))
                    echo "<li class=\"selected\">&nbsp;<a href = \"reservation_results.php?page=" . ($i + 1) . "\" >" . ($i + 1) . "</a>&nbsp;</li>";
                    //                        else
                    //                            echo "<li>&nbsp;<a href = \"reservation_results.php?page=" . ($i + 1) . "\" >" . ($i + 1) . "</a>&nbsp;</li>";
                }
            }echo '</ul>';
            echo '</div>';
        }
        ?>

        <div class="wrap">
            <div id="preferences_menu" >
                <h2 class="underline">Preferencje</h2>
                <form action="reservation_results.php" method="POST">
                    Ilość pokoi:<br />
                    <input type="radio" name="nazwa" value="wartość" checked="checked" />1 pokój<br />
                    <input type="radio" name="nazwa" value="wartość" checked="checked" />2 pokoje<br />
                    <input type="radio" name="nazwa" value="wartość" checked="checked" />3 pokoje<br />
                    Łazienka:<br />
                    <input type="radio" name="nazwa" value="wartość" checked="checked" />Tak<br />
                    <input type="radio" name="nazwa" value="wartość" checked="checked" />Nie<br />

                    <input type="submit"  value="Filtruj wyniki"  /><br />
                </form>
            </div>
            <div id="reservation_result" >
                <h2 class="underline">Dostępne pokoje</h2>
                <?php
                include('PHP_Helper.php');
                $dateFrom = $_POST['dateFromHidden'];
                $dateTo = $_POST['dateToHidden'];
                //echo $_GET['str_output'];
                //$zapytanie = "SELECT * FROM pokoje";
                $zapytanie = "SELECT * FROM Rezerwacje r JOIN Pokoje p ON(r.numer=p.numer) 
                    WHERE od_kiedy>to_date('" . $dateFrom . "','yyyy-mm-dd') AND od_kiedy>to_date('" . $dateTo . "','yyyy-mm-dd')
                        OR
                        do_kiedy<to_date('" . $dateFrom . "','yyyy-mm-dd') AND do_kiedy<to_date('" . $dateTo . "','yyyy-mm-dd')";
                //echo $zapytanie;
                if (PHP_Helper::getCount($zapytanie) == 0)
                    echo 'Niestety wszystkie pokoje są zajęte w danym terminie.';
                else {
                    showAvailableRooms($zapytanie, $dateFrom, $dateTo);
                }
                ?>
            </div>
        </div>
        <?php include('footer.php'); ?>
    </body>
</html>