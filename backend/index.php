<?php

session_start();
$login = $_POST['login1'];
$haslo = $_POST['haslo1'];
$typ = $_POST['typ'];
$_SESSION['login1'] = $login;
$_SESSION['haslo1'] = $haslo;
$_SESSION['typ'] = $typ;
echo $_SESSION['login1'];
echo $typ;
if ($typ == 'worker') {
    header('Location: guest_list.php');
} else if ($typ == 'admin') {
    header('Location: workers_index.php');
}
?>
