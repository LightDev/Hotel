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
        ;
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

        function showActualGuests() {
            $zapytanie = "SELECT imie, nazwisko,to_char(od_kiedy,'dd/mm/yyyy') od,to_char(do_kiedy,'dd/mm/yyyy') do
                FROM Pokoje p  JOIN Rezerwacje r ON (p.numer=r.numer) JOIN Goscie g ON (r.id_goscia=g.id)
                WHERE SYSDATE between od_kiedy and do_kiedy";

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
            </thead>
            <tbody>
                <?php
                $from = 1; //{5}

                while ($rekord = oci_fetch_array($wyrazenie, OCI_ASSOC)) {
                    echo "<tr><td>" . $from . "</td><td>" .
                    $rekord['IMIE'] . "</td><td>" . $rekord['NAZWISKO'] . "</td><td>" . $rekord['OD'] . "</td><td>" . $rekord['DO'] . "</td>";
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
            <h2 class="underline extraBottomMargin">Aktualna lista go¶ci (<?php echo(date("d-m-Y | G:i:s", time())); ?>)</h2>
            <?php
            showActualGuests();
            //echo $manager->getHtmlHeaderCode();
            ?>
            <!--<h1>Liczba go¶ci w poprzednich dniach</h1>-->
            <?php //echo $pieChart->getHtmlContainer();       ?>
        </div>
    </div>
    <div id="footer">Panel Administracyjny</div>
</body>
</html>
