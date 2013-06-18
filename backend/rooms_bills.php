<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8">-->

        <?php
        include('../createHead.php');
        createHead("Admin", "../");
        ?>

    </head>

    <body>
        <?php

        function showBills() {

            $zapytanie = "SELECT numer_rezerwacji,imie, nazwisko, r.numer, to_char(od_kiedy,'dd/mm/yyyy') od, to_char(do_kiedy,'dd/mm/yyyy') do,zaplata,klucz 
                          FROM Pokoje p  JOIN Rezerwacje r ON (p.numer=r.numer) JOIN Goscie g ON (r.id_goscia=g.id)
                          WHERE (od_kiedy<=TRUNC(SYSDATE-1)) and klucz='Y'
                          order by 6";

            $polaczenie = oci_connect("hotel", "hotel", "localhost/XE");
            $wyrazenie = oci_parse($polaczenie, $zapytanie);
            if (!oci_execute($wyrazenie)) {
                $err = oci_error($wyrazenie);
                trigger_error('Zapytanie zakoĹ?czyĹ?o siÄ? niepowodzeniem: ' . $err ['message'], E_USER_ERROR);
            }
            include('../PHP_Helper.php');
            $rowsCount = PHP_Helper::getCount($zapytanie);
            //echo $rowsCount;
            if ($rowsCount == 0) {
                echo 'Nie posiadasz aktualnych rezerwacji.';
            } else
            if ($rowsCount > 0) {
                ?>
                <table id="table-6" >
                    <thead>
                    <th>No.</th>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                    <th>Pokój</th>
                    <th>Od</th>
                    <th>Do</th>
                    <th>Akcja</th>
                </thead>
                <tbody>
                    <?php
                    $from = 1; //{5}

                    while ($rekord = oci_fetch_array($wyrazenie, OCI_ASSOC)) {
                        // $_POST['reservation_id'] = $rekord["NUMER_REZERWACJI"];
                        //$_SESSION['roomId'] = $rekord['NUMER'];
                        // $_SESSION['od'] = $rekord['OD'];
                        // $_SESSION['do'] = $rekord['DO'];
                        $_SESSION['bill_nr_rez'] = $rekord['NUMER_REZERWACJI'];
                        echo "<tr><td>" . $from . "</td><td>" .
                        $rekord['IMIE'] . "</td>
                                <td>" . $rekord['NAZWISKO'] . "</td>
                                    <td>" . $rekord['NUMER'] . "</td>
                                        <td>" . $rekord['OD'] . "</td
                                            ><td>" . $rekord['DO'] . "</td>
                            <td><a href=\"generate_bill.php?id=" . $rekord['NUMER_REZERWACJI'] . "\" class = \"button gradient_silver\">Wyświetl</a></td></tr>";
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
    <?php
    include('header.php');
//include('../navigation.php');
    ?>
    <div class="wrap">
        <?php include('menu.php'); ?>
        <div id = "TRESC">
            <h1 class="underline extraBottomMargin">Lista rachunków do wygenerowania (<?php echo(date("d-m-Y | G:i:s", time())); ?>)</h1>
            <?php
//            $od = '2013-06-14';
//            $do = '2013-06-17';
            $od = 'SYSDATE';
            $do = 'SYSDATE';

            showBills();
            echo "<br />";
            ?>
        </div>
    </div>
    <div id="footer">Panel Administracyjny</div>
</body>
</html>
