<html xmlns = "http://www.w3.org/1999/xhtml">
    <head>

        <?php
        include('createHead.php');
        createHead("H&R - Rezerwacja pokoi");
        ?>
    </head>

    <body>
        <?php
        error_reporting(E_ALL);
        include('header.php');
        include('navigation.php');
        ?>

        <div class="wrap">
            <div id="menu" >
                <h2 class="underline">Preferencje</h2>

            </div>
            <div id="content" >
                <h2 class="underline">Dostępne pokoje</h2>

            </div>
        </div>
        <?php include('footer.php'); ?>
    </body>
</html>