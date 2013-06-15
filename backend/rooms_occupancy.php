<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <!--<meta http-equiv = "Content-Type" content = "text/html; charset=iso8852-2">-->

        <?php
        include('../createHead.php');
        createHead("Admin", "../");
        ?>

    </head>

    <body>
        <?php

        function showRooms($zapytanie, $od, $do) {

            $polaczenie = oci_connect("hotel", "hotel", "localhost/XE");
            $wyrazenie = oci_parse($polaczenie, $zapytanie);
            if (!oci_execute($wyrazenie)) {
                $err = oci_error($wyrazenie);
                trigger_error('Zapytanie zakoÅ?czyÅ?o siÄ? niepowodzeniem: ' . $err ['message'], E_USER_ERROR);
            }
            ?>
            <table id="table-6" >
                <thead>
                <th>No.</th>
                <th>Pokój</th>
            </thead>
            <tbody>
                <?php
                $from = 1; //{5}

                while ($rekord = oci_fetch_array($wyrazenie, OCI_ASSOC)) {
                    echo "<tr>
                        <td>" . $from . "</td>
                        <td>" . $rekord['NUMER'] . "</td>
                            </tr>";
                    $from++;
                }
                //$rowsCount = oci_num_rows($wyrazenie);
                oci_close($polaczenie);
                ?>
            </tbody>
        </table>
    <?php } ?>
    <?php
    include('../header.php');
//include('../navigation.php');
    ?>
    <div class="wrap">
        <?php include('menu.php'); ?>
        <div id = "TRESC">
            <h1 class="underline extraBottomMargin">Zajêto¶æ pokoi (<?php echo(date("d-m-Y | G:i:s", time())); ?>)</h1>
            <?php
            $od = '2013-06-14';
            $do = '2013-06-17';
//            $zapytanie = "SELECT r.numer suma FROM Rezerwacje r JOIN Pokoje p ON(r.numer=p.numer) 
//                WHERE od_kiedy>to_date('{$od}','yyyy-mm-dd') 
//                AND   do_kiedy<to_date('{$do}','yyyy-mm-dd')";
            $zapytanie = "select numer 
                          from pokoje 
                          where numer not in (
                            SELECT p.numer
                            FROM Rezerwacje r JOIN Pokoje p ON(r.numer=p.numer) 
                            WHERE od_kiedy<=to_date('{$od}','yy-mm-dd') AND do_kiedy>=to_date('{$do}','yy-mm-dd')
                            or
                            (r.od_kiedy  between to_date('{$od}','yy/mm/dd') and to_date('{$do}','yy/mm/dd')) or
                            ( r.do_kiedy  between to_date('{$od}','yy/mm/dd') and to_date('{$do}','yy/mm/dd')))
                         order by 1";
            echo "<br /><h1 class=\"underline\">Wolne pokoje</h1>";
            echo "<br />";
            showRooms($zapytanie, $od, $do);
            echo "<br />";
//            $zapytanie = "SELECT r.numer FROM Rezerwacje r JOIN Pokoje p ON(r.numer=p.numer)
//            WHERE od_kiedy<=to_date('{$od}','yyyy-mm-dd') 
//            AND   do_kiedy>=to_date('{$do}','yyyy-mm-dd')";
            $zapytanie = "SELECT r.numer 
 FROM Rezerwacje r JOIN Pokoje p ON(r.numer=p.numer) 
 WHERE od_kiedy<=to_date('{$od}','yy-mm-dd') AND do_kiedy>=to_date('{$do}','yy-mm-dd')
or
(r.od_kiedy  between to_date('{$od}','yy/mm/dd') and to_date('{$do}','yy/mm/dd')) or
( r.do_kiedy  between to_date('{$od}','yy/mm/dd') and to_date('{$do}','yy/mm/dd'))
order by 1";
            echo "<br /><h1 class=\"underline\">Zajete pokoje</h1>";
            echo "<br />";
            showRooms($zapytanie, $od, $do);
            echo "<br />";
            ?>
        </div>
    </div>
    <div id="footer">Panel Administracyjny</div>
</body>
</html>
