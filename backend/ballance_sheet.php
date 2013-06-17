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

        function showIncomeRoom($roomId) {
            //2a - zmienna nr - numer pokoju - przychĂłd za pokoj
            'SELECT sum(cena) suma FROM Rezerwacje r JOIN Pokoje p ON(r.numer=p.numer) WHERE r.numer=\'' . $roomId . '\'';
        }

        function showIncomeLastMonth() {
            //2b - przychod w miesiacyu

            $zapytanie = 'SELECT sum(cena) suma
                FROM Rezerwacje NATURAL JOIN Pokoje
                WHERE EXTRACT(MONTH FROM od_kiedy)=EXTRACT(MONTH FROM SYSDATE) AND
                      EXTRACT(MONTH FROM do_kiedy)=EXTRACT(MONTH FROM SYSDATE)';

            $polaczenie = oci_connect("hotel", "hotel", "localhost/XE");
            $wyrazenie = oci_parse($polaczenie, $zapytanie);
            if (!oci_execute($wyrazenie)) {
                $err = oci_error($wyrazenie);
                trigger_error('Zapytanie zakoÄšâczyÄšâo siĂâ˘ niepowodzeniem: ' . $err ['message'], E_USER_ERROR);
            }
            $from = 1; //{5}

            while ($rekord = oci_fetch_array($wyrazenie, OCI_ASSOC)) {
                echo "<tr><td>" . $from . "</td><td>" .
                $rekord['IMIE'] . "</td><td>" . $rekord['NAZWISKO'] . "</td>";
                $from++;
            }
            //$rowsCount = oci_num_rows($wyrazenie);
            oci_close($polaczenie);
        }

        function showIncomeLastWeek() {
            //2b - przychod w minionum tygodniu
            "SELECT sum(cena) suma FROM Rezerwacje NATURAL JOIN Pokoje WHERE
        od_kiedy>=( select to_date(SYSDATE,'yyyy-mm-dd')+interval'-7'day from dual) AND do_kiedy<=SYSDATE";
        }

        function showAllRoomsIncome() {
            //2b - przychod w miesiacyu

            $polaczenie = oci_connect("hotel", "hotel", "localhost/XE");
            $zapytanie = "SELECT do_kiedy-od_kiedy ile_dni from rezerwacje";

            $wyrazenie = oci_parse($polaczenie, $zapytanie);
            if (!oci_execute($wyrazenie)) {
                $err = oci_error($wyrazenie);
                trigger_error('Zapytanie zakoÄšâczyÄšâo siĂâ˘ niepowodzeniem: ' . $err ['message'], E_USER_ERROR);
            }
            $tab = array();
            $i = 0;
            while ($rekord = oci_fetch_array($wyrazenie, OCI_ASSOC)) {
                $tab[$i] = $rekord['ILE_DNI'];
                $i++;
            }
            //var_dump($tab);

            $zapytanie = "SELECT p.numer,nvl(sum(cena),0) suma 
FROM Rezerwacje r, Pokoje p  
WHERE p.numer=r.numer
group by p.numer
union 
SELECT p.numer,0suma
FROM Rezerwacje r, Pokoje p  
WHERE 
p.numer not in (SELECT p.numer
          FROM Rezerwacje r, Pokoje p  
          WHERE p.numer=r.numer
          group by p.numer)
group by p.numer
order by 2 desc
";

            $wyrazenie = oci_parse($polaczenie, $zapytanie);
            if (!oci_execute($wyrazenie)) {
                $err = oci_error($wyrazenie);
                trigger_error('Zapytanie zakoÄšâczyÄšâo siĂâ˘ niepowodzeniem: ' . $err ['message'], E_USER_ERROR);
            }
            $from = 1; //{5}
            $i = 0;
            //echo "tab count " . count($tab) . "<br>";
            while ($rekord = oci_fetch_array($wyrazenie, OCI_ASSOC)) {
                echo "<tr><td>" . $from . "</td><td>" .
                $rekord['NUMER'] . "</td><td>" . (($i < count($tab) ) ? ($rekord['SUMA'] * $tab[$i] ) : $rekord['SUMA'] ) . " zl</td>";
                $from++;
                $i++;
            }
            oci_close($polaczenie);
        }
        ?>


        <?php
        include('header.php');
//include('../navigation.php');
        ?>
        <div class="wrap">
            <?php include('menu.php'); ?>
            <div id = "TRESC">
                <h1 class="underline extraBottomMargin">Zestawienia finansowe ( <?php echo(date("d-m-Y | G:i:s", time())); ?>)</h1>
                <h2 class="underline extraBottomMargin">Sumaryczne przychody pokoi</h2>
                <table id="table-6">
                    <thead>
                    <th>No.</th>
                    <th>Pokój</th>
                    <th>Kwota</th>
                    </thead>
                    <tbody>
                        <?php showAllRoomsIncome(); ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="footer">Panel Administracyjny</div>
    </body>
</html>
