<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <?php
        include('../createHead.php');
        createHead("Admin", "../");
        ?>
    </head>
    <body>
        <?php include('../header.php'); ?>
        <div class="wrap">
            <?php include('menu_admin.php'); ?>
            <div id = "TRESC">
                <h1 class="underline extraBottomMargin">Zarzadzanie pokojami( <?php echo(date("d-m-Y | G:i:s", time())); ?>)</h1>
                <h2 class="underline extraBottomMargin">Dodaj pokoj</h2>
                <table id="table-6">
                    <tbody>
                        <tr><td>Numer</td><td><input type="text" /></td></tr>
                        <tr><td>Ilu osobowy</td><td><select name="ilu_osobowy">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select></td></tr>
                        <tr><td>Lazienka</td><td><select name="lazienka">
                                    <option>Tak</option>
                                    <option>Nie</option>
                                </select></td></tr>
                        <tr><td>Cena</td><td><input type="text" /></td></tr>
                    </tbody>
                </table>
                <br />
                <h2 class="underline extraBottomMargin">Modyfikuj pokoj</h2>
                Numer pokoju:<input name="id" type="text" />
                <br />
                <br />
                <h2 class="underline extraBottomMargin">Usuñ pokoj</h2>
                Numer pokoju:<input name="id" type="text" />
                <br />
                <h2 class="underline extraBottomMargin">Poka¿ wszystkie</h2>
                <a href="show_workers.php" class="button gradient_silver">Poka¿</a>
            </div>
        </div>
    </body>
</html>
