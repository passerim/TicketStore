<?php
function isActive($pagename)
{
    if (basename($_SERVER['PHP_SELF']) == $pagename) {
        echo " class='active' ";
    }
}

function getIdFromName($name)
{
    return preg_replace("/[^a-z]/", '', strtolower($name));
}

function isAdminLoggedIn()
{
    return !empty($_SESSION['idadmin']);
}

function isOrganizerLoggedIn()
{
    return !empty($_SESSION['idorganizzatore']);
}

function isClientLoggedIn()
{
    return !empty($_SESSION['idcliente']);
}

function registerLoggedAdmin($user)
{
    $_SESSION["idadmin"] = 1;
    $_SESSION["nome"] = 'Admin';
    $_SESSION["email"] = $user["Email"];
}

function registerLoggedUser($user)
{
    $_SESSION["idcliente"] = $user["IdUtente"];
    $_SESSION["email"] = $user["Email"];
    $_SESSION["nome"] = $user["Nome"];
}

function registerLoggedOrganizer($user)
{
    $_SESSION["idorganizzatore"] = $user["IdOrganizzatore"];
    $_SESSION["email"] = $user["Email"];
    $_SESSION["nome"] = $user["Nome"];
}

function getEmptyEvent()
{
    return array("IdEvento" => "", "Nome" => "", "Immagine" => "", "Descrizione" => "", "Anteprima" => "", "categorie" => array());
}

function getEmptyClasse()
{
    return array("IdEvento" => "", "NomeClasse" => "", "Prezzo" => "", "Quantita" => "");
}

function getAction($action)
{
    $result = "";
    switch ($action) {
        case 1:
            $result = "Inserisci";
            break;
        case 2:
            $result = "Modifica";
            break;
        case 3:
            $result = "Cancella";
            break;
        case 4:
            $result = "Approva";
            break;
    }

    return $result;
}

function uploadImage($path, $image)
{
    $imageName = basename($image["name"]);
    $fullPath = $path . $imageName;

    $maxKB = 500;
    $acceptedExtensions = array("jpg", "jpeg", "png", "gif");
    $result = 0;
    $msg = "";
    //Controllo se immagine è veramente un'immagine
    $imageSize = getimagesize($image["tmp_name"]);
    if ($imageSize === false) {
        $msg .= "File caricato non è un'immagine! ";
    }
    //Controllo dimensione dell'immagine < 500KB
    if ($image["size"] > $maxKB * 1024) {
        $msg .= "File caricato pesa troppo! Dimensione massima è $maxKB KB. ";
    }

    //Controllo estensione del file
    $imageFileType = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
    if (!in_array($imageFileType, $acceptedExtensions)) {
        $msg .= "Accettate solo le seguenti estensioni: " . implode(",", $acceptedExtensions);
    }

    //Controllo se esiste file con stesso nome ed eventualmente lo rinomino
    if (file_exists($fullPath)) {
        $i = 1;
        do {
            $i++;
            $imageName = pathinfo(basename($image["name"]), PATHINFO_FILENAME) . "_$i." . $imageFileType;
        } while (file_exists($path . $imageName));
        $fullPath = $path . $imageName;
    }

    //Se non ci sono errori, sposto il file dalla posizione temporanea alla cartella di destinazione
    if (strlen($msg) == 0) {
        if (!move_uploaded_file($image["tmp_name"], $fullPath)) {
            $msg .= "Errore nel caricamento dell'immagine.";
        } else {
            $result = 1;
            $msg = $imageName;
        }
    }
    return array($result, $msg);
}

function logoutUser()
{
    $_SESSION = [];
}

function sec_session_start()
{
    $session_name = 'sec_session_id'; // Imposta un nome di sessione
    $secure = false; // Imposta il parametro a true se vuoi usare il protocollo 'https'.
    $httponly = true; // Questo impedirà ad un javascript di essere in grado di accedere all'id di sessione.
    ini_set('session.use_only_cookies', 1); // Forza la sessione ad utilizzare solo i cookie.
    $cookieParams = session_get_cookie_params(); // Legge i parametri correnti relativi ai cookie.
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
    session_name($session_name); // Imposta il nome di sessione con quello prescelto all'inizio della funzione.
    session_start(); // Avvia la sessione php.
    session_regenerate_id(); // Rigenera la sessione e cancella quella creata in precedenza.
}
