<html xmlns = "http://www.w3.org/1999/xhtml">
    <head>

        <?php
        include('createHead.php');
        createHead("H&R - Rejestracja");
        ?>
    </head>

    <body>
        <?php
        error_reporting(E_ALL);
        //include('header.php');

        include('navigation.php');
        ?>

        <div class="wrap">
            <div id="content" style="margin: 20px;">
                <h2 class="underline">Rejestracja przebiegła pomyślnie</h2>

                <p><a href="index.php">Przejdź do strony głównej</a></p>
            </div>
        </div>
        <div id="footer footer_registration">
            <div class="wrap">
                <p><span class="bold">Hotel & Restaurant</span> <span class="splitter">&nbsp;|&nbsp;</span>
                    <a href="#">Najczęściej zadawane pytania</a><span class="splitter">&nbsp;|&nbsp;</span>
                    <a href="#">Regulamin rezerwacji</a><span class="splitter">&nbsp;|&nbsp;</span>
                    <a href="#">Kontakt</a></p>
                <p style="width: 200px;float: right">Webdesign: 8SOFT &copy; 2013</p>
            </div>
        </div>

    </body>
</html>