<html xmlns = "http://www.w3.org/1999/xhtml">
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <?php
        include('createHead.php');
        createHead("H&R - Rezerwacja pokoi");

        function deleteReservation($id) {
            $zapytanie = "DELETE FROM Rezerwacje WHERE numer_rezerwacji=" . $id;

            $polaczenie = oci_connect("hotel", "hotel", "localhost/XE");
            $wyrazenie = oci_parse($polaczenie, $zapytanie);
            if (!oci_execute($wyrazenie)) {
                $err = oci_error($wyrazenie);
                trigger_error('Zapytanie zakoĹ?czyĹ?o siÄ? niepowodzeniem: ' . $err ['message'], E_USER_ERROR);
            }
            echo "Rezerwacja o numerze " . $id . " została anulowana pomyślnie.";
            oci_close($polaczenie);
        }
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
            <?php include('user_menu.php'); ?>
            <div id="reservation_result" >
                <!--<h1 class="ok_text">Anulowanie rezerwacji przebieglo pomyślnie</h1>-->
                <br />
                <?php deleteReservation($_GET['id']); ?>

                <br />
            </div>
        </div>
        <?php include('footer.php'); ?>
    </body>
</html>