<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <?php
        include('../createHead.php');
        createHead("Admin", "../");

        function showRooms() {
            $zapytanie = "SELECT * FROM obsluga";

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
            <th>Imię</th>
            <th>Nazwisko</th>
            <th>Login</th>
            <th>Pensja</th>
            <th>Akcja</th>

        </thead>
        <tbody>
            <?php
            $from = 1; //{5}

            while ($rekord = oci_fetch_array($wyrazenie, OCI_ASSOC)) {
                echo "<tr>
                        <td>" . $from . "</td>
                        <td>" . $rekord['IMIE'] . "</td>
                        <td>" . $rekord['NAZWISKO'] . "</td>
                        <td>" . $rekord['LOGIN'] . "</td>
                        <td>" . $rekord['PENSJA'] . "</td>
<td><a href=\"workers_modify_form.php?id=" . $rekord["ID"] . "\" class=\"button gradient_silver\">Modyfikuj</a></td></tr>";
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
            <h1 class="underline extraBottomMargin">Wybierz pracownika do modyfikacji (<?php echo(date("d-m-Y | G:i:s", time())); ?>)</h1>
            <?php showRooms(); ?>
        </div>
    </div>
</body>
</html>
