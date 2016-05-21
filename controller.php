<?php
// Lisab uue kasutajakonto
function controller_register($kasutajanimi, $parool)
{
    if ($kasutajanimi == '' || $parool == '') {
       // message_add('Vigased sisendandmed');

        return false;
    }

    if (model_user_add($kasutajanimi, $parool)) {
       // message_add('Konto on registreeritud');

        return true;
    }

   // message_add('Konto registreerimine ebaõnnestus, kasutajanimi võib olla juba võetud');

    return false;
}