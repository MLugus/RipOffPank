<?php

$host = 'localhost';
$user = 'test';
$pass = 't3st3r123';
$db = 'test';

$l = mysqli_connect($host, $user, $pass, $db);
mysqli_query($l, 'SET CHARACTER SET UTF8');

// BROKEN , DON'T RELY ON IT YET
function model_load()
{
    global $l;


    $query = 'SELECT Id, Nimetus, Kogus FROM mlugus__kasutajad ORDER BY Nimetus ';
    $stmt = mysqli_prepare($l, $query);
    if (mysqli_error($l)) {
        echo mysqli_error($l);
        exit;
    }
    mysqli_stmt_bind_param($stmt, 'ii');
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $nimetus, $kogus);

    $rows = array();
    while (mysqli_stmt_fetch($stmt)) {
        $rows[] = array(
            'id' => $id,
            'nimetus' => $nimetus,
            'kogus' => $kogus,
        );
    }

    mysqli_stmt_close($stmt);

    return $rows;
}

/**
* Lisab andmebaasi uue kasutaja. Õnnestub vaid juhul kui sellist kasutajat veel pole.
 * Parool salvestatakse BCRYPT räsina.
 *
 * @param string $kasutajanimi Kasutaja nimi
* @param string $parool       Kasutaja parool
*
 * @return int lisatud kasutaja ID
*/
function model_user_add($kasutajanimi, $parool)
{
    global $l;

    $hash = password_hash($parool, PASSWORD_DEFAULT);

    $query = 'INSERT INTO mlugus__kasutajad (kasutajanimi, parool) VALUES (?, ?)';
    $stmt = mysqli_prepare($l, $query);
    if (mysqli_error($l)) {
        echo mysqli_error($l);
        exit;
    }

    mysqli_stmt_bind_param($stmt, 'ss', $kasutajanimi, $hash);
    mysqli_stmt_execute($stmt);

    $id = mysqli_stmt_insert_id($stmt);

    mysqli_stmt_close($stmt);

    return $id;
}

/**
 * Tagastab kasutaja ID, kelle kasutajanimi ja parool klapivad sisendiga.
 *
 * @param string $kasutajanimi Otsitava kasutaja kasutajanimi
 * @param string $parool       Otsitava kasutaja parool
 *
 * @return int Kasutaja ID
 */
function model_user_get($kasutajanimi, $parool)
{
    global $l;

    $query = 'SELECT id, parool FROM mlugus__kasutajad WHERE kasutajanimi=? LIMIT 1';
    $stmt = mysqli_prepare($l, $query);
    if (mysqli_error($l)) {
        echo mysqli_error($l);
        exit;
    }

    mysqli_stmt_bind_param($stmt, 's', $kasutajanimi);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $hash);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // kontrollime, kas vabateksti $parool klapib baasis olnud räsiga $hash
    if (password_verify($parool, $hash)) {
        return $id;
    }

    return false;
}