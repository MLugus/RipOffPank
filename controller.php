<?php
// Lisab uue kasutajakonto
function controller_register($kasutajanimi, $parool, $parool2)
{
    if ($kasutajanimi == '' || $parool == '') {
        message_add(' Vigased sisendandmed');

        return false;
    }
    if ($parool != $parool2) {
        message_add(' paroolid ei klapi!');
        return false;
    }

    if (model_user_add($kasutajanimi, $parool)) {
        return true;
    }

    message_add(' Konto registreerimine ebaõnnestus, kasutajanimi võib olla juba võetud');

    return false;
}

// Logib kasutaja sisse
function controller_login($kasutajanimi, $parool)
{
    if ($kasutajanimi == '' || $parool == '') {
        message_add(' Vigased sisendandmed');

        return false;
    }

    $id = model_user_get($kasutajanimi, $parool);
    if (!$id) {
        message_add(' Vigane kasutajanimi või parool');

        return false;
    }

    session_regenerate_id();
    $_SESSION['login'] = $id;


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

}

// Kontrollib kas kasutaja on sisse logitud
function controller_user()
{
    if (empty($_SESSION['login'])) {
        return false;
    }

    return $_SESSION['login'];
}


/**
 * Lisab uue makse, kontrollib sisendeid ja kontojääki ning kas ülekanne tehtav, selle summaga.
 * @param $saaja
 * @param $summa
 * @return bool
 */
function controller_makse($saaja, $summa)
{

    if (!controller_user()) {
        message_add(' Tegevus eeldab sisselogimist');

        return false;
    }

    if (model_user_id($saaja) == 0) {
        message_add(' Sellist kasutajat pole meil andmebaasis');
        return false;
    }

    // kontrollime kas sisendväärtused on oodatud kujul või mitte
    if ($saaja == '' || $summa <= 0) {
        message_add(' Vigased sisendandmed');

        return false;
    }
    if ((model_user_kontoseis($_SESSION['login']) - $summa) <= 0) {
        message_add(' Teie kontol pole piisavalt raha tehinguks');
        return false;
    }

    if (model_makse($saaja, $summa)) {
        message_add(' tehing õnnestus!!');
        return true;
    }
    message_add(' tehing ebaõnnestus');

    return false;
}

// Lisab järjekorda uue sõnumi kasutajale kuvamiseks
function message_add($message)
{
    if (empty($_SESSION['messages'])) {
        $_SESSION['messages'] = array();
    }
    $_SESSION['messages'][] = $message;
}

// Tagastab kõik hetkel ootel olevad sõnumid
function message_list()
{
    if (empty($_SESSION['messages'])) {
        return array();
    }
    $messages             = $_SESSION['messages'];
    $_SESSION['messages'] = array();

    return $messages;
}