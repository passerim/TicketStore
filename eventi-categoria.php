<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "TicketStore - Eventi";
$templateParams["nome"] = "home.php";
$templateParams["categorie"] = $dbh->getCategories();
$templateParams["eventicasuali"] = $dbh->getRandomEvents(2);

//Eventi Categoria Template
$nomecategoria = -1;
if(isset($_GET["id"])){
    $nomecategoria = $_GET["id"];
}
$eventicategoria = $dbh->getEventsByCategory($nomecategoria);
if(count($eventicategoria)>0){
    $templateParams["titolo"] = "Blog TW - Eventi ".$nomecategoria;
    $templateParams["titolo_pagina"] = "Eventi della categoria ".$nomecategoria;
    $templateParams["eventi"] = $eventicategoria;
}
else{
    $templateParams["titolo_pagina"] = "Categoria non trovata"; 
    $templateParams["eventi"] = array();   
}

require 'template/base.php';
?>