<?php
require_once 'bootstrap.php';

if ((!isAdminLoggedIn()) || !isset($_POST["action"])) {
    header("location: login.php");
}

if ($_POST["action"] == 1 && !isAdminLoggedIn() && !isOrganizerLoggedIn() && !isClientLoggedIn()) {
    //Inserisco
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $email = $_POST["email"];
    $res = $dbh->emailDuplicated($email);
    if ($res) {
        header('Location: /TicketStore/signup.php?ucat=cl&error=-1');
        exit;
    }
    $città = $_POST["città"];
    $indirizzo = $_POST["indirizzo"];
    $password = $_POST["password"];
    $hashed = hash("sha256", $password);
    $id = $dbh->insertUser($nome, $cognome, $email, $hashed, $città, $indirizzo);
    if ($id != false) {
        $msg = "Registrazione completata correttamente! Accedi ora.";
    } else {
        $msg = "Errore in inserimento!";
    }
    header("location: login.php?formmsg=" . $msg);
}

if ($_POST["action"] == 3) {
    //cancello
    $idcliente = $_POST["idcliente"];
    $dbh->deleteClient($idcliente);
    $msg = "Cancellazione completata correttamente!";
    header("location: login.php?formmsg=" . $msg);
}
