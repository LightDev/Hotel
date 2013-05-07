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
                $zapytanie = "SELECT * FROM pokoje";

                $polaczenie = oci_connect("hotel", "hotel", "localhost/XE");
                $wyrazenie = oci_parse($polaczenie, $zapytanie);
                if (!oci_execute($wyrazenie)) {
                    $err = oci_error($wyrazenie);
                    trigger_error('Zapytanie zakończyło się niepowodzeniem: ' . $err ['message'], E_USER_ERROR);
                }
                while ($rekord = oci_fetch_array($wyrazenie, OCI_ASSOC)) {
                    echo '<h2 class="underline">' . $rekord['NUMER'] . '</h2>';
                    echo 'Ilość osób: ' . $rekord['ILU_OSOBOWY'] . '<br />';
                    echo 'Łazienka: ' . ($rekord['LAZIENKA'] == 'Y') ? 'Tak' : 'Nie' . '<br />';
                    echo 'CENA: ' . $rekord['CENA'] . ' zł' . '<br />';
                    if ($_SESSION['uzytkownik'] > 0) {
                        echo '<a href = "reservation_summary.php" class = "button gradient_gold">Dokonaj rezerwacji</a>';
                    } else {
                        echo '<a href = "register.php" class = "button gradient_gold">Dokonaj rezerwacji</a>';
                    }
                    echo '<h2 class="underline"></h2>';
                }//bez tej petli nie dziala oci_num_rows
                $rowsCount = oci_num_rows($wyrazenie);
                oci_close($polaczenie);


                echo "<div class=\"pager\">";
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
                ?>
            </div>
        </div>
        <?php include('footer.php'); ?>
    </body>
</html>