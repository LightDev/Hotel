<html xmlns = "http://www.w3.org/1999/xhtml">
    <head>

        <?php
        include('createHead.php');
        createHead("H&R - Rezerwacja pokoi");

        function showOldReservations() {
            $zapytanie = "SELECT r.numer,od_kiedy, do_kiedy  
                          FROM Pokoje p  JOIN Rezerwacje r ON (p.numer=r.numer) JOIN Goscie g ON (r.id_goscia=g.id) 
                          WHERE  (do_kiedy < SYSDATE-1) and id_goscia={$_SESSION['user']} ORDER BY 3 DESC";

            $polaczenie = oci_connect("hotel", "hotel", "localhost/XE");
            $wyrazenie = oci_parse($polaczenie, $zapytanie);
            if (!oci_execute($wyrazenie)) {
                $err = oci_error($wyrazenie);
                trigger_error('Zapytanie zako�?czy�?o si�? niepowodzeniem: ' . $err ['message'], E_USER_ERROR);
            }
            ?>
            <table id="table-6" >
                <thead>
                    <th>No.</th>
                    <th>Pok�j</th>
                    <th>Od</th>
                    <th>Do</th>
                </thead>
                <tbody>
                    <?php
                    $from = 1; //{5}

                    while ($rekord = oci_fetch_array($wyrazenie, OCI_ASSOC)) {
                        echo "<tr><td>" . $from . "</td><td>" . $rekord['NUMER'] . "</td><td>" . $rekord['OD_KIEDY'] . "</td><td>" . $rekord['DO_KIEDY'] . "</td></tr>";
                        $from++;
                    }
                    //$rowsCount = oci_num_rows($wyrazenie);
                    oci_close($polaczenie);
                    ?>
                </tbody>
            </table>
        <?php } ?>

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
                <h1 class="underline">Historia rezerwacji</h1>
                <br />
                <?php showOldReservations(); ?><br />
            </div>
        </div>
        <?php include('footer.php'); ?>
    </body>
</html>