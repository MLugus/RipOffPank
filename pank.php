<?php

session_start();

// laeme andmete haldamise meetodid
require 'model.php';

// laeme andmete modifitseerimise meetodid
require 'controller.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    // $result muutuja indikeerib kas toimus mõni õnnestunud tegevus või mitte
    $result = false;

    switch($_SERVER['action']){

        case 'register':
            $kasutajanimi = $_POST['kasutajanimi'];
            $parool = $_POST['parool'];
            $result = controller_register($kasutajanimi, $parool);
            break;

        case 'login':
            $kasutajanimi = $_POST['kasutajanimi'];
            $parool = $_POST['parool'];
            $result = controller_login($kasutajanimi, $parool);
            break;

        case 'logout':
            $result = controller_logout();
            break;

    }

    header('Location: '.$_SERVER['PHP_SELF']);
    // POST päringu puhul me sisu ei näita
    exit;
}

// Rakenduse "ruuter" GET päringu puhul
if (!empty($_GET['view'])) {
    switch ($_GET['view']) {
        case 'login':
            require 'vaade_login.php';
            break;
        case 'register':
            require 'vaade_rega.php';
            break;
        default:
            header('Content-type: text/plain; charset=utf-8');
            echo 'Tundmatu valik!';
            exit;
    }
} else {
    if (!controller_user()) {
        header('Location: '.$_SERVER['PHP_SELF'].'?view=login');
        exit;
    }

    require 'vaade_pealeht.php';
}

mysqli_close($l);


