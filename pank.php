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

    }

}