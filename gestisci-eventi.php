<?php
require_once 'bootstrap.php';

/*if(!isUserLoggedIn() || !isset($_GET["action"]) || ($_GET["action"]!=1 && $_GET["action"]!=2 && $_GET["action"]!=3) || ($_GET["action"]!=1 && !isset($_GET["id"]))){
    header("location: login.php");
}*/

if($_GET["action"]!=1){
    $risultato = $dbh->getEventById($_GET["id"]);
    if(count($risultato)==0){
        $templateParams["evento"] = null;
        $templateParams["classibiglietti"] = null;
    }
    else{
        $templateParams["evento"] = $risultato[0];
        $templateParams["evento"]["categorie"] = explode(",", $templateParams["evento"]["categorie"]);
        $templateParams["classibiglietti"] = getEmptyClasse();
    }
}
else{
    $templateParams["evento"] = getEmptyEvent();
    $templateParams["classibiglietti"] = getEmptyClasse();
}




$templateParams["titolo"] = "Blog TW - Gestisci Eventi";
$templateParams["nome"] = "login/organizzatore/organizzatore-form.php";
$templateParams["categorie"] = $dbh->getCategories();

$templateParams["azione"] = $_GET["action"];

require 'template/base.php';
?>