<html xmlns = "http://www.w3.org/1999/xhtml">
    <head>

        <?php
        include('createHead.php');
        createHead("H&R - Rezerwacja pokoi");

        function availableRooms($dateFrom, $dateTo) {
            echo $dateFrom . "<br>";
            echo $dateTo;
            $zapytanie = "SELECT distinct p.numer,od_kiedy,do_kiedy    FROM Rezerwacje r JOIN Pokoje p ON(r.numer=p.numer)";
//                    WHERE od_kiedy>to_date('" . $dateFrom . "','yy-mm-dd') AND od_kiedy>to_date('" . $dateTo . "','yy-mm-dd')
//                        OR
//                        do_kiedy<to_date('" . $dateFrom . "','yy-mm-dd') AND do_kiedy<to_date('" . $dateTo . "','yy-mm-dd') order by 1";

            $polaczenie = oci_connect("hotel", "hotel", "localhost/XE");
            $wyrazenie = oci_parse($polaczenie, $zapytanie);
            if (!oci_execute($wyrazenie)) {
                $err = oci_error($wyrazenie);
                trigger_error('Zapytanie zakoñczy³o siê niepowodzeniem: ' . $err ['message'], E_USER_ERROR);
            }
            echo "lol1";
            while ($rekord = oci_fetch_array($wyrazenie, OCI_ASSOC)) {
                print "lol" . $_SESSION['roomId'] . "<br>";
                echo $rekord['NUMER'] . "<br>";
                if ($_SESSION['roomId'] == $rekord ['NUMER'])//$_POST['dept_name'] == $rekord ['DEPARTMENT_NAME'])//|| 
                    echo '<option selected>' . $rekord ['NUMER'] . '</option>';
                else
                    echo '<option >' . $rekord ['NUMER'] . '</option>';
            }
            oci_close($polaczenie);
        }

        function showActualReservation($id) {
            $zapytanie = "SELECT numer_rezerwacji,imie, nazwisko, r.numer, od_kiedy, do_kiedy 
                          FROM Pokoje p  JOIN Rezerwacje r ON (p.numer=r.numer) JOIN Goscie g ON (r.id_goscia=g.id)
                          WHERE (od_kiedy>=TRUNC(SYSDATE-1)) and id_goscia={$_SESSION['user']} AND numer_rezerwacji=" . $id;

            $polaczenie = oci_connect("hotel", "hotel", "localhost/XE");
            $wyrazenie = oci_parse($polaczenie, $zapytanie);
            if (!oci_execute($wyrazenie)) {
                $err = oci_error($wyrazenie);
                trigger_error('Zapytanie zakoÅ?czyÅ?o siÄ? niepowodzeniem: ' . $err ['message'], E_USER_ERROR);
            }
            $rowsCount = PHP_Helper::getCount($zapytanie);
//            $rowsCount = oci_fetch($wyrazenie);
            if ($rowsCount == 0) {
                echo 'Nie posiadasz aktualnych rezerwacji.';
            } else if ($rowsCount > 0) {
                ?>
                <table id="table-6" >
        <!--                    <thead>
                        <th>Atrybut</th>
                        <th>Wartosc</th>
                    </thead>-->
                    <tbody>
                        <?php
                        $from = 1; //{5}
                        while ($rekord = oci_fetch_array($wyrazenie, OCI_ASSOC)) {
                            // $_POST['reservation_id'] = $rekord["NUMER_REZERWACJI"];
                            echo "<tr>
                               <tr> <td>Pokój:</td>        <td><select name=\"room\">";
                            availableRooms($rekord['OD_KIEDY'], $rekord['DO_KIEDY']);
                            echo "</select></td></tr>
                                <tr><td>Od:</td>            <td>" . $rekord['OD_KIEDY'] . "</td></tr>
                                <tr><td>Do:</td>                <td>" . $rekord['DO_KIEDY'] . "</td></tr>
                            <tr><td><a href=\"modify_reservation_summary.php\" class=\"button gradient_gold\">Modyfikuj</a></td></tr></tr>";
                            $from++;
                        }
                        //$rowsCount = oci_num_rows($wyrazenie);
                        oci_close($polaczenie);
                        ?>
                    </tbody>
                </table>
                <?php
            }
        }
        ?>

    </head>

    <body>
        <?php
        error_reporting(E_ALL);
        include('header.php');
        include('navigation.php');
        include('PHP_Helper.php');
        include('Users/User.php');
        include('Users/HotelGuest.php');
        ?>

        <div class="wrap">
            <?php include('user_menu.php'); ?>
            <div id="reservation_result" >
                <h1 class="underline">Modyfikujesz rezerwacje</h1>
                <br />
                <?php showActualReservation($_GET['id']); ?><br />
            </div>
        </div>
        <?php include('footer.php'); ?>
    </body>
</html>