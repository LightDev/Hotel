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
                <form action="room_add_summary.php" method="POST">
                    <table id="table-6">
                        <tbody>
                            <tr><td>Numer</td><td><input type="text" name="numer" /></td></tr>
                            <tr><td>Ilu osobowy</td><td><select name="ilu_osobowy">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                    </select></td></tr>
                            <tr><td>Lazienka</td><td><select name="lazienka">
                                        <option>Tak</option>
                                        <option>Nie</option>
                                    </select></td></tr>
                            <tr><td>Cena</td><td><input type="text" name="cena" /></td></tr>
                            <tr><td></td><td><input type="submit" class="button gradient_silver" value="Dodaj" /></td></tr>
                        </tbody>
                    </table>
                </form>
                <br />
            </div>
        </div>
    </body>
</html>
