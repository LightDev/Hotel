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
        ?>

        <div class="wrap">
            <div id="preferences_menu" >
                <!--                <h2 class="underline">Preferencje</h2>
                                <form action="reservation_results.php" method="POST">
                                    Ilość pokoi:<br />
                                    <input type="radio" name="nazwa" value="wartość" checked="checked" />1 pokój<br />
                                    <input type="radio" name="nazwa" value="wartość" checked="checked" />2 pokoje<br />
                                    <input type="radio" name="nazwa" value="wartość" checked="checked" />3 pokoje<br />
                                    Łazienka:<br />
                                    <input type="radio" name="nazwa" value="wartość" checked="checked" />Tak<br />
                                    <input type="radio" name="nazwa" value="wartość" checked="checked" />Nie<br />
                
                                    <input type="submit"  value="Filtruj wyniki"  /><br />
                                </form>-->
            </div>
            <div id="reservation_result" >
                <!--<h2 class="underline">Dostępne pokoje</h2>-->
                <?php
                $roomId = $_GET['roomId'];
                //$dateTo = $_POST['dateToHidden'];
                //echo $_GET['str_output'];
                //$zapytanie = "SELECT * FROM pokoje";
                $zapytanie = "SELECT * FROM Pokoje WHERE numer='" . $roomId . "'";

                $polaczenie = oci_connect("hotel", "hotel", "localhost/XE");
                $wyrazenie = oci_parse($polaczenie, $zapytanie);
                if (!oci_execute($wyrazenie)) {
                    $err = oci_error($wyrazenie);
                    trigger_error('Zapytanie zakończyło się niepowodzeniem: ' . $err ['message'], E_USER_ERROR);
                }
                while ($rekord = oci_fetch_array($wyrazenie, OCI_ASSOC)) {
                    echo '<h2 class="underline">' . $rekord['NUMER'] . '</h2>';
                    echo '<table>';
                    echo '<tr><td>Ilość osób: ' . $rekord['ILU_OSOBOWY'] . '</td>';
                    echo ($rekord['LAZIENKA'] == 'Y') ? '<td>Łazienka: ' . 'Tak' : 'Łazienka: ' . 'Nie' . '</td>';
                    echo '<td>CENA: ' . $rekord['CENA'] . ' zł' . '</td>';
                    if ($_SESSION['uzytkownik'] > 0) {
                        echo '<td><a href = "reservation_after_summary.php" class = "button gradient_gold">Dokonaj rezerwacji</a></td>';
                    } else {
                        echo '<td><a href = "register.php" class = "button gradient_gold">Dokonaj rezerwacji</a></td>';
                    }
                    echo '</tr></table>';
                    echo '<h2 class="underline"></h2>';
                }//bez tej petli nie dziala oci_num_rows
                oci_close($polaczenie);
                ?>
            </div>
        </div>
        <?php include('footer.php'); ?>
    </body>
</html>