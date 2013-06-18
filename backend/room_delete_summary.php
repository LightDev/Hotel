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
            <?php
            include('menu_admin.php');
            include('../Users/User.php');
            include('../Users/HotelAdministrator.php');
            include('../PHP_Helper.php');
            ?>
            <div id = "TRESC">
                <h1 class="underline extraBottomMargin">Usuwanie pokoju (<?php echo(date("d-m-Y | G:i:s", time())); ?>)</h1>
                <?php
                $room = new HotelAdministrator();
                $numer = $_GET['numer'];
                $isRoomRemoved = $room->deleteRoom($numer);
                if ($isRoomRemoved == true) {
                    echo "Pokój o numerze {$numer} został usunięty pomyślnie";
                }
                else
                    echo "Błąd usuwania pokoju.";
                ?>
            </div>
        </div>
    </body>
</html>
