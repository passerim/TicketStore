<?php
require_once 'bootstrap.php';

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $_GET["formmsg"] = "";
    $pwd = hash("sha256", $_POST["password"]);
    $login_result = $dbh->checkLogin($_POST["email"], $pwd);
    if (empty($login_result) || count($login_result) == 0) {
        //Login fallito
        $templateParams["errorelogin"] = "Controllare email o password!";
    } else {
        if ($login_result[0]["usertype"] == 0) {
            registerLoggedAdmin($login_result[0]);
        } else if ($login_result[0]["usertype"] == 1) {
            registerLoggedOrganizer($login_result[0]);
        } else if ($login_result[0]["usertype"] == 2) {
            registerLoggedUser($login_result[0]);
        }
    }
}

if (isAdminLoggedIn()) {
    if (isset($_GET["page"]) && $_GET["page"] == 1) {
        $templateParams["titolo"] = "TicketStore - Admin";
        $templateParams["nome"] = "login/admin/login-organizzatori-admin.php";
        $templateParams["organizzatori"] = $dbh->getOrganizers();
        if (isset($_GET["formmsg"])) {
            $templateParams["formmsg"] = $_GET["formmsg"];
        }
    } else if (isset($_GET["page"]) && $_GET["page"] == 2) {
        $templateParams["titolo"] = "TicketStore - Admin";
        $templateParams["nome"] = "login/admin/login-clienti-admin.php";
        $templateParams["clienti"] = $dbh->getClients();
        if (isset($_GET["formmsg"])) {
            $templateParams["formmsg"] = $_GET["formmsg"];
        }
    } else if (isset($_GET["page"]) && $_GET["page"] == 3) {
        $templateParams["titolo"] = "TicketStore - Admin";
        $templateParams["nome"] = "login/admin/login-approva-admin.php";
        $templateParams["eventi"] = $dbh->getNonApprovedEvents();
        if (isset($_GET["formmsg"])) {
            $templateParams["formmsg"] = $_GET["formmsg"];
        }
    } else {
        $templateParams["titolo"] = "TicketStore - Admin";
        $templateParams["nome"] = "login/admin/login-home-admin.php";
        $templateParams["eventi"] = $dbh->getEventsOrderedId();
        if (isset($_GET["formmsg"])) {
            $templateParams["formmsg"] = $_GET["formmsg"];
        }
    }
} else if (isOrganizerLoggedIn()) {
    if (isset($_GET["page"]) && $_GET["page"] == 1) {
        $templateParams["titolo"] = "TicketStore - Organizzatore";
        $templateParams["nome"] = "login/organizzatore/login-notifiche-organizzatore.php";
        if (isset($_GET["formmsg"])) {
            $templateParams["formmsg"] = $_GET["formmsg"];
        }
    } else {
        $templateParams["titolo"] = "TicketStore - Organizzatore";
        $templateParams["nome"] = "login/organizzatore/login-home-organizzatore.php";
        $templateParams["eventi"] = $dbh->getEventsByOrganizerId($_SESSION["idorganizzatore"]);
        if (isset($_GET["formmsg"])) {
            $templateParams["formmsg"] = $_GET["formmsg"];
        }
    }
} else if (isClientLoggedIn()) {
    if (isset($_GET["page"]) && $_GET["page"] == 1) {
        $templateParams["titolo"] = "TicketStore - Cliente";
        $templateParams["nome"] = "login/cliente/login-notifiche-cliente.php";
        if (isset($_GET["formmsg"])) {
            $templateParams["formmsg"] = $_GET["formmsg"];
        }
    } else {
        $templateParams["titolo"] = "TicketStore - Cliente";
        $templateParams["nome"] = "login/cliente/login-home-cliente.php";
        $templateParams["eventi"] = $dbh->getEventsByClientId($_SESSION["idcliente"]);
        if (isset($_GET["formmsg"])) {
            $templateParams["formmsg"] = $_GET["formmsg"];
        }
    }
} else {
    $templateParams["titolo"] = "TicketStore - Login";
    $templateParams["nome"] = "login-form.php";
}

require 'template/base.php';
