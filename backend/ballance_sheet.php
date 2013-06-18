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
use googlecharttools\view\ColumnChart;
use googlecharttools\view\ChartManager;

require_once("./googlecharttools/ClassLoader.class.php");

        //include('googleChartsRequirements.php');

        function showIncomeRoom($roomId) {
            //2a - zmienna nr - numer pokoju - przychĂłd za pokoj
            'SELECT sum(cena) suma FROM Rezerwacje r JOIN Pokoje p ON(r.numer=p.numer) WHERE r.numer=\'' . $roomId . '\'';
        }

        function showIncomeLastMonth() {
            //2b - przychod w miesiacyu

            $zapytanie = 'SELECT numer,cena*(EXTRACT(DAY FROM SYSDATE)-EXTRACT(DAY FROM od_kiedy)) suma
                FROM Rezerwacje NATURAL JOIN Pokoje
                WHERE EXTRACT(MONTH FROM od_kiedy)=EXTRACT(MONTH FROM SYSDATE) AND
                      EXTRACT(MONTH FROM do_kiedy)=EXTRACT(MONTH FROM SYSDATE)
                      and cena*(EXTRACT(DAY FROM SYSDATE)-EXTRACT(DAY FROM od_kiedy))>0';

            $polaczenie = oci_connect("hotel", "hotel", "localhost/XE");
            $wyrazenie = oci_parse($polaczenie, $zapytanie);
            if (!oci_execute($wyrazenie)) {
                $err = oci_error($wyrazenie);
                trigger_error('Zapytanie zakoÄšâczyÄšâo siĂâ˘ niepowodzeniem: ' . $err ['message'], E_USER_ERROR);
            }
            $from = 1; //{5}
            $activitiesData = new DataTable();
            $activitiesData->addColumn(new Column(Column::TYPE_STRING, "t", "Task"));
            $activitiesData->addColumn(new Column(Column::TYPE_NUMBER, "h", "Przychód"));

            while ($rekord = oci_fetch_array($wyrazenie, OCI_ASSOC)) {

                $rowWork = new Row();
                $rowWork->addCell(new Cell($rekord['NUMER']))->addCell(new Cell($rekord['SUMA']));
                $activitiesData->addRow($rowWork);

                echo "<tr><td>" . $from . "</td>
                    <td>" . $rekord['NUMER'] . "</td>
                    <td>" . $rekord['SUMA'] . "</td>";
                $from++;
            }
            $pieChart = new ColumnChart("activitiesPie", $activitiesData);
            //$pieChart = new PieChart("activitiesPie", $activitiesData);
            $pieChart->setTitle("Przychód z ostaniego miesiąca");

            $manager = new ChartManager();
            $manager->addChart($pieChart);

            //$rowsCount = oci_num_rows($wyrazenie);
            oci_close($polaczenie);
            $tab["manager"] = $manager;
            $tab["chart"] = $pieChart;
            return $tab;
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
SELECT p.numer,0 suma
FROM Rezerwacje r, Pokoje p  
WHERE 
p.numer not in (SELECT p.numer
          FROM Rezerwacje r, Pokoje p  
          WHERE p.numer=r.numer
          group by p.numer)
group by p.numer
order by suma desc
";

            $wyrazenie = oci_parse($polaczenie, $zapytanie);
            if (!oci_execute($wyrazenie)) {
                $err = oci_error($wyrazenie);
                trigger_error('Zapytanie zakoÄšâczyÄšâo siĂâ˘ niepowodzeniem: ' . $err ['message'], E_USER_ERROR);
            }
            $from = 1; //{5}
            $i = 0;
            //echo "tab count " . count($tab) . "<br>";
            $activitiesData = new DataTable();
            $activitiesData->addColumn(new Column(Column::TYPE_STRING, "t", "Task"));
            $activitiesData->addColumn(new Column(Column::TYPE_NUMBER, "h", "Przychód"));

            while ($rekord = oci_fetch_array($wyrazenie, OCI_ASSOC)) {

                $rowWork = new Row();
                $rowWork->addCell(new Cell($rekord['NUMER']))->addCell(new Cell($rekord['SUMA']));
                $activitiesData->addRow($rowWork);

                echo "<tr><td>" . $from . "</td><td>" .
                $rekord['NUMER'] . "</td><td>" . (($i < count($tab) ) ? ($rekord['SUMA'] * $tab[$i] ) : $rekord['SUMA'] ) . " zl</td>";
                $from++;
                $i++;
            }

            $pieChart = new ColumnChart("activitiesPie2", $activitiesData);
            //$pieChart = new PieChart("activitiesPie", $activitiesData);
            $pieChart->setTitle("Przychód sumaryczny");

            $manager = new ChartManager();
            $manager->addChart($pieChart);

            //$rowsCount = oci_num_rows($wyrazenie);
            oci_close($polaczenie);
            $tab["manager"] = $manager;
            $tab["chart"] = $pieChart;
            return $tab;
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
                <h2 class="underline extraBottomMargin">Przychody pokoi z ostatniego miesiaca</h2>
                <table id="table-6">
                    <thead>
                    <th>No.</th>
                    <th>Pokój</th>
                    <th>Kwota</th>
                    </thead>
                    <tbody>
                        <?php $chart = showIncomeLastMonth(); ?>
                    </tbody>
                </table>
                <br>
                <br>
                <?php echo $chart["manager"]->getHtmlHeaderCode(); ?>

                <?php echo $chart["chart"]->getHtmlContainer(); ?>

                <h2 class="underline extraBottomMargin">Sumaryczne przychody pokoi</h2>
                <table id="table-6">
                    <thead>
                    <th>No.</th>
                    <th>Pokój</th>
                    <th>Kwota</th>
                    </thead>
                    <tbody>
                        <?php $chart2 = showAllRoomsIncome(); ?>
                    </tbody>
                </table>
                <br>
                <br>
                <?php echo $chart2["manager"]->getHtmlHeaderCode(); ?>
                <?php echo $chart2["chart"]->getHtmlContainer(); ?>

            </div>
        </div>
        <div id="footer">Panel Administracyjny</div>
    </body>
</html>
