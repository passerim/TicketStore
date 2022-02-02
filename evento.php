<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "TicketStore - Evento";
$templateParams["nome"] = "singolo-evento.php";
$templateParams["categorie"] = $dbh->getCategories();

//Home Template
$idevento = -1;
if (isset($_GET["id"])) {
    $idevento = $_GET["id"];
}
$templateParams["evento"] = $dbh->getEventById($idevento);
if (isset($_GET["from"]) && ($_GET["from"] == "cl" || $dbh->isEventSoldOut($templateParams["evento"]))) {
    $templateParams["buy"] = false;
}

require 'template/base.php';
