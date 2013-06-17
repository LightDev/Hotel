<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <?php
        include('../createHead.php');
        createHead("Admin", "../");

        function showRooms() {
            $zapytanie = "SELECT * FROM pokoje                             ";

//WHERE SYSDATE between od_kiedy and do_kiedy";

            $polaczenie = oci_connect("hotel", "hotel", "localhost/XE");
            $wyrazenie = oci_parse($polaczenie, $zapytanie);
            if (!oci_execute($wyrazenie)) {
                $err = oci_error($wyrazenie);
                trigger_error('Zapytanie zakoĹ?czyĹ?o siÄ? niepowodzeniem: ' . $err ['message'], E_USER_ERROR);
            }
            ?>
        <table id="table-6" >
            <thead>
            <th>No.</th>
            <th>Pokój</th>
            <th>Ilu osobowy</th>
            <th>Łazienka</th>
            <th>Cena</th>
        </thead>
        <tbody>
            <?php
            $from = 1; //{5}

            while ($rekord = oci_fetch_array($wyrazenie, OCI_ASSOC)) {
                echo "<tr>
                        <td>" . $from . "</td>
                        <td>" . $rekord['NUMER'] . "</td>
                        <td>" . $rekord['ILU_OSOBOWY'] . "</td>
                        <td>" . ($rekord['LAZIENKA'] == 'Y' ? 'Tak' : 'Nie') . "</td>
                        <td>" . $rekord['CENA'] . "</td>
                            </tr>";
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
    <?php include('header.php'); ?>
    <div class="wrap">
        <?php include('menu_admin.php'); ?>
        <div id = "TRESC">
            <h1 class="underline extraBottomMargin">Lista wszystkich pokoi (<?php echo(date("d-m-Y | G:i:s", time())); ?>)</h1>
            <?php showRooms(); ?>
        </div>
    </div>
</body>
</html>
