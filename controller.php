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

// Logib kasutaja sisse
function controller_login($kasutajanimi, $parool)
{
    if ($kasutajanimi == '' || $parool == '') {
        //message_add('Vigased sisendandmed');

        return false;
    }

    $id = model_user_get($kasutajanimi, $parool);
    if (!$id) {
        //message_add('Vigane kasutajanimi või parool');

        return false;
    }

    session_regenerate_id();
    $_SESSION['login'] = $id;

    //message_add('Oled nüüd sisse logitud');

    return $id;
}

// Logib kasutaja välja
function controller_logout()
{
    // muuda sessiooni ku?psis kehtetuks
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 42000, '/');
    }

    // tühjenda sessiooni massiiv
    $_SESSION = array();
    // lõpeta sessioon
    session_destroy();

    //message_add('Oled nüüd välja logitud');

    return true;
}