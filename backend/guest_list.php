<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv = "Content-Type" content = "text/html; charset=UTF-8">

        <?php
        include('../createHead.php');
        createHead("Admin", "../");
        ?>
        <style type="text/css">
            /* <![CDATA[ */

            body{
                /*background-color: #eee;*/
            }
            #MENU {

                width: 150px;
                float: left;
                /*overflow: hidden;*/
                background-color: #ccc;
                background: #fff;
                /*box-shadow:2px 2px 5px #3D3C3C;*/
            }
            #MENU a{
                color: #000;
            }
            #MENU ul{
                width: 145px;
                /*border: 1px solid #ddd;*/
                /*border-top: 5px solid #1F5D9B;*/
                -webkit-border-radius: 0px 0px 7px 7px;
                -moz-border-radius: 0px 0px 7px 7px;
                border-radius: 0px 0px 7px 7px;

                box-shadow:1px 1px 4px #807D7D;


            }
            #MENU ul li {
                border-bottom: 1px solid #000;
                padding: 5px;

            }
            #MENU ul li:hover {
                background: #3297FD;
                color: #fff;
            }
            #MENU ul li:last-child {
                border-bottom: none;
                -webkit-border-radius: 0px 0px 7px 7px;
                -moz-border-radius: 0px 0px 7px 7px;
                border-radius: 0px 0px 7px 7px;
            }
            #MENU ul li a{
                font-family: "Lucida Grande", Arial, Helvetica, Geneva, Sans-serif;
                font-size: 11px;
                font-weight: bold;

            }
            /*            #MENU ul li:hover{
                            background: #1F5D9B;
                            color: #fff;
                        }*/
            #MENU ul li a:hover{
                background: #3297FD;
                color: #fff;
                padding: 3px;
            }

            #TRESC {
                padding: 10px;
                width: 730px;
                float: left;
                overflow: hidden;
                background-color: #fff;
            }

            #STOPKA {
                clear: both;
                width: 100%;
                background-color: #888;
            }
            /* ]]> */
        </style>

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
            $zapytanie = 'SELECT imie, nazwisko
                FROM Pokoje p  JOIN Rezerwacje r ON (p.numer=r.numer) JOIN Goscie g ON (r.id_goscia=g.id)
                WHERE od_kiedy>=SYSDATE';

            $polaczenie = oci_connect("hotel", "hotel", "localhost/XE");
            $wyrazenie = oci_parse($polaczenie, $zapytanie);
            if (!oci_execute($wyrazenie)) {
                $err = oci_error($wyrazenie);
                trigger_error('Zapytanie zakoĹ„czyĹ‚o siÄ™ niepowodzeniem: ' . $err ['message'], E_USER_ERROR);
            }
            ?>
            <table id="table-6" >
                <thead>
                <th>No.</th>
                <th>Imię</th>
                <th>Nazwisko</th>
            </thead>
            <tbody>
                <?php
                $from = 1; //{5}

                while ($rekord = oci_fetch_array($wyrazenie, OCI_ASSOC)) {
                    echo "<tr><td>" . $from . "</td><td>" .
                    $rekord['IMIE'] . "</td><td>" . $rekord['NAZWISKO'] . "</td>";
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
            <h2 class="underline extraBottomMargin">Aktualna lista gości (<?php echo(date("d-m-Y | G:i:s", time())); ?>)</h2>
            <?php
            showActualGuests();
            //echo $manager->getHtmlHeaderCode();
            ?>
            <!--<h1>Liczba gości w poprzednich dniach</h1>-->
            <?php //echo $pieChart->getHtmlContainer();       ?>
        </div>
    </div>
    <div id="footer">Panel Administracyjny</div>
</body>
</html>
