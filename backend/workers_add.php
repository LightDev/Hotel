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
        <?php include('header.php'); ?>
        <div class="wrap">
            <?php include('menu_admin.php'); ?>
            <div id = "TRESC">
                <h1 class="underline extraBottomMargin">Zarządzanie pracownikami( <?php echo(date("d-m-Y | G:i:s", time())); ?>)</h1>
                <h2 class="underline extraBottomMargin">Dodaj pracownika</h2>
                <table id="table-6">
                    <tbody>
                        <tr><td>Imie</td><td><input name="imie" type="text" /></td></tr>
                        <tr><td>Nazwisko</td><td><input name="nazwisko" type="text" /></td></tr>
                        <tr><td>Login</td><td><input name="login" type="text" /></td></tr>
                        <tr><td>Haslo</td><td><input name="haslo" type="text" /></td></tr>
                        <tr><td>Pensja</td><td><input name="pensja" type="text" /></td></tr>
                        <tr><td></td><td><a href="workers_add_summary.php" class="button gradient_silver">Dodaj</a></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
