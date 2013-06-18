<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <?php
        include('../createHead.php');
        createHead("Admin", "../");
        ?>
    </head>
    <body>
        <?php include('header.php'); ?>
        <div class="wrap">
            <?php include('menu_admin.php'); ?>
            <div id = "TRESC">
                <h1 class="underline extraBottomMargin">Zarzadzanie pokojami( <?php echo(date("d-m-Y | G:i:s", time())); ?>)</h1>
                <h2 class="underline extraBottomMargin">Dodaj pokój</h2>
                <h2 class="ok_text">Dodano pomyślnie</h2><br><br><br>
                <table id="table-6">
                    <tbody>
                        <tr><td>Numer</td><td><?php echo $_POST['numer']; ?></td></tr>
                        <tr><td>Ilu osobowy</td><td><?php echo $_POST['ilu_osobowy']; ?></td></tr>
                        <tr><td>Lazienka</td><td><?php echo $_POST['lazienka']; ?></td></tr>
                        <tr><td>Cena</td><td><?php echo $_POST['cena']; ?></td></tr>
                    </tbody>
                </table>
                <br />
            </div>
        </div>
    </body>
</html>
