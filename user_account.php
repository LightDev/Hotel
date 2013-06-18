<html xmlns = "http://www.w3.org/1999/xhtml">
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <?php
        include('createHead.php');
        createHead("H&R - Rezerwacja pokoi");

        function showActualReservations() {
//            $zapytanie = "SELECT imie, nazwisko, r.numer, od_kiedy, do_kiedy 
//                          FROM Pokoje p  JOIN Rezerwacje r ON (p.numer=r.numer) JOIN Goscie g ON (r.id_goscia=g.id)
//                          WHERE (od_kiedy>=TRUNC(SYSDATE-1)) and id_goscia='{$_SESSION['user']}'";

            $zapytanie = "SELECT imie, nazwisko, r.numer, od_kiedy, do_kiedy, 'AKTYWNA' STATUS
                          FROM Pokoje p  JOIN Rezerwacje r ON (p.numer=r.numer) JOIN Goscie g ON (r.id_goscia=g.id)
                          WHERE (od_kiedy>=TRUNC(SYSDATE-1)) and id_goscia='{$_SESSION['user']}'
                          and SYSDATE between od_kiedy-1 and do_kiedy+1
                          UNION
                         SELECT imie, nazwisko, r.numer, od_kiedy, do_kiedy, 'NIEAKTYWNA' STATUS
                          FROM Pokoje p  JOIN Rezerwacje r ON (p.numer=r.numer) JOIN Goscie g ON (r.id_goscia=g.id)
                          WHERE (od_kiedy>=TRUNC(SYSDATE-1)) and id_goscia='{$_SESSION['user']}'
                          and SYSDATE not between od_kiedy-1 and do_kiedy+1
                          order by 4";

            $polaczenie = oci_connect("hotel", "hotel", "localhost/XE");
            $wyrazenie = oci_parse($polaczenie, $zapytanie);
            if (!oci_execute($wyrazenie)) {
                $err = oci_error($wyrazenie);
                trigger_error('Zapytanie zakoĹ?czyĹ?o siÄ? niepowodzeniem: ' . $err ['message'], E_USER_ERROR);
            }
            $rowsCount = PHP_Helper::getCount($zapytanie);
            if ($rowsCount == 0) {
                echo 'Nie posiadasz aktualnych rezerwacji.';
            } else if ($rowsCount > 0) {
                ?>
                <table id="table-6" >
                    <thead>
                        <th>No.</th>
                        <th>Imię</th>
                        <th>Nazwisko</th>
                        <th>Pokój</th>
                        <th>Od</th>
                        <th>Do</th>
                        <th>Status</th>
                        <!--<th>Akcja</th>-->
                    </thead>
                    <tbody>
                        <?php
                        $from = 1; //{5}

                        while ($rekord = oci_fetch_array($wyrazenie, OCI_ASSOC)) {
                            echo "<tr>
                                <td>" . $from . "</td>
                                <td>" . $rekord['IMIE'] . "</td>
                                <td>" . $rekord['NAZWISKO'] . "</td>
                                <td>" . $rekord['NUMER'] . "</td>
                                <td>" . $rekord['OD_KIEDY'] . "</td>
                                <td>" . $rekord['DO_KIEDY'] . "</td>
                                <td>" . (($rekord['STATUS'] == "AKTYWNA") ? '<span style="color:green;">' . $rekord['STATUS'] . '</span>' : '<span style="color:red;">' . $rekord['STATUS'] . '</span>') . "</td></tr>";
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
                <h1 class="underline">Złożone rezerwacje</h1>
                <br />
                <?php showActualReservations(); ?>
                <br />
            </div>
        </div>
        <?php include('footer.php'); ?>
    </body>
</html>