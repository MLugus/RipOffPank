<?php

session_start();

// genereerime sessiooni jaoks unikaalse CSRF tokeni
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(20));
}

// laeme andmete haldamise meetodid
require 'model.php';

// laeme andmete modifitseerimise meetodid
require 'controller.php';

// rakenduse "ruuter" POST päringu puhul
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // $result muutuja indikeerib kas toimus mõni õnnestunud tegevus või mitte
    $result = false;

    // Lubame postitustegevused ainult juhul kui päringuga tuleb kaasa korrektne CSRF token.
    // Eeelab, et paneksime kõikidesse lehe vormidesse selle tokeni peidetud väljana sisse
    if (!empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token']) {
        switch ($_POST['action']) {

            case 'register':
                $kasutajanimi = $_POST['kasutajanimi'];
                $parool       = $_POST['parool'];
                $parool2      = $_POST['parool2'];
                $result       = controller_register($kasutajanimi, $parool, $parool2);
                break;

            case 'login':
                $kasutajanimi = $_POST['kasutajanimi'];
                $parool       = $_POST['parool'];
                $result       = controller_login($kasutajanimi, $parool);
                break;

            case 'logout':
                controller_logout();
                break;

            case 'makse':
                $saaja = $_POST['saaja'];
                $summa = $_POST['summa'];
                controller_makse($saaja, $summa);
                break;

        }
    } else {
        message_add('Vigane päring, CSRF token ei vasta oodatule');
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    // POST päringu puhul me sisu ei näita
    exit;
}

// Rakenduse "ruuter" GET päringu puhul, PEAKS RESTRICKTIMA JUURDEPÄÄSU TEISTELE FAILIDELE.php AGA EI RESTRICKTI
if (!empty($_GET['view'])) {
    switch ($_GET['view']) {
        case 'login':
            require 'vaade_login.php';
            break;
        case 'register':
            require 'vaade_rega.php';
            break;
        case 'makse':
            require 'vaade_makse.php';
            break;
        case 'tehingud':
            require 'vaade_ajalugu.php';
            break;
        case 'pealeht':
            require 'vaade_pealeht.php';
            break;
        default:
            header('Content-type: text/plain; charset=utf-8');
            echo 'Tundmatu valik!';
            exit;
    }
} else {
    if (!controller_user()) {
        header('Location: ' . $_SERVER['PHP_SELF'] . '?view=login');
        exit;
    }

    require 'vaade_pealeht.php';
}

mysqli_close($l);
