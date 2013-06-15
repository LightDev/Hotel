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
                <h1 class="underline extraBottomMargin">Zarzadzanie pracownikami( <?php echo(date("d-m-Y | G:i:s", time())); ?>)</h1>
                <h2 class="underline extraBottomMargin">Dodaj pracownika</h2>
                <table id="table-6">
                    <tbody>
                        <tr><td>Imie</td><td><input name="imie" type="text" /></td></tr>
                        <tr><td>Nazwisko</td><td><input name="nazwisko" type="text" /></td></tr>
                        <tr><td>Login</td><td><input name="login" type="text" /></td></tr>
                        <tr><td>Haslo</td><td><input name="haslo" type="text" /></td></tr>
                        <tr><td>Pensja</td><td><input name="pensja" type="text" /></td></tr>
                    </tbody>
                </table>
                <h2 class="underline extraBottomMargin">Modyfikuj pracownika</h2>
                Numer pracownika:<input name="id" type="text" />
                <h2 class="underline extraBottomMargin">Usuñ pracownika</h2>
                Numer pracownika:<input name="id" type="text" />
                <h2 class="underline extraBottomMargin">Poka¿ wszystkich</h2>
                <a href="show_workers.php" class="button gradient_silver">Poka¿</a>
            </div>
        </div>
    </body>
</html>
