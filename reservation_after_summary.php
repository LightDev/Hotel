<html xmlns = "http://www.w3.org/1999/xhtml">
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

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
        include('PHP_Helper.php');
        include('Users/User.php');
        include('Users/HotelGuest.php');
        ?>

        <div class="wrap">
            <div id="preferences_menu" >
            </div>
            <div id="reservation_result" >
                <?php
                $roomId = $_POST['roomId'];
                $guestId = $_SESSION['user'];
                $dateFrom = $_SESSION['dateFromHidden'];
                echo $dateFrom;
                $dateTo = $_SESSION['dateToHidden'];
                $hotelGuest = new HotelGuest();
                $hotelGuest->bookOnline($roomId, $guestId, $dateFrom, $dateTo);
                ?>
                <h2 class="ok_text">Rezerwacja została złożona</h2>
                <p><a href="user_account.php" >Przejdz do Twoich rezerwacji</a></p>
                <p><a href="index.php" >Wróć na stronę główną</a></p>
            </div>
        </div>
        <?php include('footer.php'); ?>
    </body>
</html>