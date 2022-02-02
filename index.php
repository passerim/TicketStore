<?php
require_once 'bootstrap.php';

if (isset($_GET["logout"]) && $_GET["logout"]==1 && (isset($_SESSION["idorganizzatore"])||isset($_SESSION["idcliente"])||isset($_SESSION["idadmin"]))){
    $_SESSION = [];
}

//Base Template
$templateParams["titolo"] = "TicketStore - Home";
$templateParams["nome"] = "home.php";
$templateParams["categorie"] = $dbh->getCategories();
$templateParams["eventicasuali"] = $dbh->getRandomEvents(1);

//Home Template
$templateParams["eventi"] = $dbh->getEvents(4);
require 'template/base.php';
?>