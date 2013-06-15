<?php

$login = $_POST['login'];
$haslo = $_POST['haslo'];
$typ = $_POST['typ'];
$_SESSION['login'] = $login;
$_SESSION['haslo'] = $haslo;
$_SESSION['typ'] = $typ;

echo $typ;
if ($typ == 'worker') {
    header('Location: guest_list.php');
} else if ($typ == 'admin') {
    header('Location: workers_index.php');
}
?>
