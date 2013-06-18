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
                <h2 class="ok_text">Dodano pomyślnie</h2><br><br><br>
                <table id="table-6">
                    <tbody>
                        <tr><td>Imie</td><td><?php echo $_POST['imie']; ?></td></tr>
                        <tr><td>Nazwisko</td><td><?php echo $_POST['nazwisko']; ?></td></tr>
                        <tr><td>Login</td><td><?php echo $_POST['login']; ?></td></tr>
                        <tr><td>Haslo</td><td><?php echo $_POST['haslo']; ?></td></tr>
                        <tr><td>Pensja</td><td><?php echo $_POST['pensja']; ?></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
