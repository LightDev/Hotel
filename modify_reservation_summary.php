<html xmlns = "http://www.w3.org/1999/xhtml">
    <head>

        <?php
        include('createHead.php');
        createHead("H&R - Rezerwacja pokoi");

        function modifyReservation($id, $numer, $od_kiedy, $do_kiedy) {
            $polaczenie = oci_connect("hotel", "hotel", "localhost/XE");
            $zapytanie = "SELECT FROM Pokoje ";
            $wyrazenie = oci_parse($polaczenie, $zapytanie);
            if (!oci_execute($wyrazenie)) {
                $err = oci_error($wyrazenie);
                trigger_error('Zapytanie zakoÅ?czyÅ?o siÄ? niepowodzeniem: ' . $err ['message'], E_USER_ERROR);
            }
            $rowsCount = PHP_Helper::getCount($zapytanie);
            if ($rowsCount == 0) {
                echo 'Nie posiadasz aktualnych rezerwacji.';
            } else if ($rowsCount > 0) {

                $zapytanie = "UPDATE Rezerwacje SET numer=" . $numer . ", od_kiedy=" . $od_kiedy . ",do_kiedy=" . $do_kiedy . "
                          WHERE numer_rezerwacji=" . $id;

                $wyrazenie = oci_parse($polaczenie, $zapytanie);
                if (!oci_execute($wyrazenie)) {
                    $err = oci_error($wyrazenie);
                    trigger_error('Zapytanie zakoÅ?czyÅ?o siÄ? niepowodzeniem: ' . $err ['message'], E_USER_ERROR);
                }
                oci_close($polaczenie);
            }
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
                <h1 class="ok_text">Modyfikacja rezerwacji przebiegla pomy¶lnie</h1>
                <br />
                <?php modifyReservation($_GET['id'], $_POST['numer'], $_POST['od'], $_POST['do']); ?>

                <br />
            </div>
        </div>
        <?php include('footer.php'); ?>
    </body>
</html>