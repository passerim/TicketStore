<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "TicketStore - Registrazione";
if (isset($_GET["ucat"]) && ($_GET["ucat"] == "cl" || $_GET["ucat"] == "org")) {
    if ($_GET["ucat"] == "cl") {
        $templateParams["nome"] = "registration/cliente.php";
    } else if ($_GET["ucat"] == "org") {
        $templateParams["nome"] = "registration/organizzatore.php";
    }
}

$templateParams["categorie"] = $dbh->getCategories();

require 'template/base.php';
