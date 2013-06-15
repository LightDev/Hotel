<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <!--<meta http-equiv = "Content-Type" content = "text/html; charset=iso8852-2">-->
        <meta http-equiv = "Content-Type" content = "text/html; charset=UTF-8">

        <?php
        include('../createHead.php');
        createHead("Admin", "../");
        ?>

    </head>

    <body>
        <?php

        use googlecharttools\model\Cell;
use googlecharttools\model\Column;
use googlecharttools\model\DataTable;
use googlecharttools\model\Row;
use googlecharttools\view\AreaChart;
use googlecharttools\view\BarChart;
use googlecharttools\view\BubbleChart;
use googlecharttools\view\CandlestickChart;
use googlecharttools\view\ColumnChart;
use googlecharttools\view\ComboChart;
use googlecharttools\view\Gauge;
use googlecharttools\view\GeoChart;
use googlecharttools\view\LineChart;
use googlecharttools\view\PieChart;
use googlecharttools\view\ScatterChart;
use googlecharttools\view\SteppedAreaChart;
use googlecharttools\view\Table;
use googlecharttools\view\TreeMap;
use googlecharttools\view\ChartManager;
use googlecharttools\view\options\Axis;
use googlecharttools\view\options\BackgroundColor;
use googlecharttools\view\options\Bubble;
use googlecharttools\view\options\ChartArea;
use googlecharttools\view\options\ColorAxis;
use googlecharttools\view\options\Legend;
use googlecharttools\view\options\Series;
use googlecharttools\view\options\TextStyle;
use googlecharttools\view\options\Tooltip;

require_once("./googlecharttools/ClassLoader.class.php");
        //include('googleChartsRequirements.php');
        $activitiesData = new DataTable();
        $activitiesData->addColumn(new Column(Column::TYPE_STRING, "t", "Task"));
        $activitiesData->addColumn(new Column(Column::TYPE_NUMBER, "h", "Hours per Day"));

        $rowWork = new Row();
        $rowWork->addCell(new Cell("Work"))->addCell(new Cell(11));

        $activitiesData->addRow($rowWork);

        $rowEat = new Row();
        $rowEat->addCell(new Cell("Eat"))->addCell(new Cell(2));
        $activitiesData->addRow($rowEat);

        $rowCommute = new Row();
        $rowCommute->addCell(new Cell("Commute"))->addCell(new Cell(2));
        $activitiesData->addRow($rowCommute);

        $rowWatch = new Row();
        $rowWatch->addCell(new Cell("Watch TV"))->addCell(new Cell(2));
        $activitiesData->addRow($rowWatch);

        $rowSleep = new Row();
        $rowSleep->addCell(new Cell("Sleep"))->addCell(new Cell(7));
        $activitiesData->addRow($rowSleep);

        $pieChart = new ColumnChart("activitiesPie", $activitiesData);
        //$pieChart = new PieChart("activitiesPie", $activitiesData);
        $pieChart->setTitle("My Daily Activities");

        $manager = new ChartManager();
        $manager->addChart($pieChart);

        function showActualGuests($od, $do) {
            $zapytanie = "SELECT imie, nazwisko,r.numer,zaplata,klucz,to_char(od_kiedy,'dd/mm/yyyy') od,to_char(do_kiedy,'dd/mm/yyyy') do
                FROM Pokoje p  JOIN Rezerwacje r ON (p.numer=r.numer) JOIN Goscie g ON (r.id_goscia=g.id)
WHERE od_kiedy<=to_date('{$od}','yy-mm-dd') AND do_kiedy>=to_date('{$do}','yy-mm-dd')
                            or
                            (r.od_kiedy  between to_date('{$od}','yy/mm/dd') and to_date('{$do}','yy/mm/dd')) or
                            ( r.do_kiedy  between to_date('{$od}','yy/mm/dd') and to_date('{$do}','yy/mm/dd'))                                
                         order by 3";

//WHERE SYSDATE between od_kiedy and do_kiedy";

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
                <th>Imiê</th>
                <th>Nazwisko</th>
                <th>Od</th>
                <th>Do</th>
                <th>Pokój</th>
                <th>Zap³acono</th>
                <th>Klucz</th>
            </thead>
            <tbody>
                <?php
                $from = 1; //{5}

                while ($rekord = oci_fetch_array($wyrazenie, OCI_ASSOC)) {
                    echo "<tr>
                        <td>" . $from . "</td>
                        <td>" . $rekord['IMIE'] . "</td>
                        <td>" . $rekord['NAZWISKO'] . "</td>
                        <td>" . $rekord['OD'] . "</td>
                        <td>" . $rekord['DO'] . "</td>.
                        <td>" . $rekord['NUMER'] . "</td>.
                        <td>" . ($rekord['ZAPLATA'] == 'Y' ? 'Tak' : 'Nie') . "</td>.
                        <td>" . ($rekord['KLUCZ'] == 'Y' ? 'Tak' : 'Nie') . "</td>";
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
            <h1 class="underline extraBottomMargin">Aktualna lista go¶ci (<?php echo(date("d-m-Y | G:i:s", time())); ?>)</h1>
            <?php
            $od = "SYSDATE";
            $do = "SYSDATE";
            $od = '13-06-14';
            $do = '13-06-14';
//          
            showActualGuests($od, $do);
            //echo $manager->getHtmlHeaderCode();
            ?>
            <!--<h1>Liczba go¶ci w poprzednich dniach</h1>-->
            <?php //echo $pieChart->getHtmlContainer();       ?>
        </div>
    </div>
    <div id="footer">Panel Administracyjny</div>
</body>
</html>
