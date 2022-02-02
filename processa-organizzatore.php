<?php
require_once 'bootstrap.php';

if ((!isAdminLoggedIn()) || !isset($_POST["action"])) {
    header("location: login.php");
}

if ($_POST["action"] == 1 && !isAdminLoggedIn() && !isOrganizerLoggedIn() && !isClientLoggedIn()) {
    //Inserisco
    $nome = $_POST["nome"];
    $descrizione = $_POST["descrizione"];
    $email = $_POST["email"];
    $indirizzo = $_POST["indirizzo"];
    $res = $dbh->emailDuplicated($email);
    if ($res) {
        header('Location: /TicketStore/signup.php?ucat=org&error=-1');
        exit;
    }
    $città = $_POST["città"];
    $password = $_POST["password"];
    $hashed = hash("sha256", $password);
    $id = $dbh->insertOrganizer($nome, $email, $hashed, $città, $indirizzo, $descrizione);
    if ($id != false) {
        $msg = "Registrazione completata correttamente! Accedi ora.";
    } else {
        $msg = "Errore in inserimento!";
    }
    header("location: login.php?formmsg=" . $msg);
}

if ($_POST["action"] == 3) {
    //cancello
    $idorganizzatore = $_POST["idorganizzatore"];
    $dbh->deleteOrganizer($idorganizzatore);
    $msg = "Cancellazione completata correttamente!";
    header("location: login.php?formmsg=" . $msg);
}

?>