<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <?php
        include('../createHead.php');
        createHead("Admin", "../");
        ?>
        <style type="text/css">
            /* <![CDATA[ */
            html, body {
                background-color: #fff;
                color: #000;
                margin: 0;
                padding: 0;
                text-align: center;
            }

            #top {
                width: 780px;
                margin-left: auto;
                margin-right: auto;
                text-align: left;
            }

            #NAGLOWEK {
                background-color: #888;
            }

            #MENU {
                width: 150px;
                float: left;
                overflow: hidden;
                background-color: #ccc;
            }

            #TRESC {
                width: 630px;
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
        ?>

        <?php
        include('../header.php');
        //include('../navigation.php');
        ?>
        <div class="wrap">
            <div id="top">
                <?php include('menu.php'); ?>

                <div id="TRESC">
                    <?php echo $manager->getHtmlHeaderCode(); ?>
                    <h1>My Charts</h1>
                    <?php echo $pieChart->getHtmlContainer(); ?>

                </div>
                <div id="STOPKA">Stopka serwisu</div>
            </div>

        </div>
    </body>
</html>
