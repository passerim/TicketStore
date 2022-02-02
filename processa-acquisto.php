<?php
require_once 'bootstrap.php';

if ($_POST["action"] == 1) {
    //acquisto
    $idcliente = intval($_SESSION["idcliente"]);
    $idevento = intval($_POST["idevento"]);
    $classe = $_POST["classeevento"];
    $num = intval($_POST["numbiglietti"]);
    $max_biglietti = intval($dbh->numTicketsEvent($idevento, $classe)[0]["Quantita"]);
    $num_biglietti = intval($dbh->ticketsSoldEvent($idevento, $classe)[0]['COUNT(*)']);
    if (($num_biglietti + $num) <= $max_biglietti) {
        $res = $dbh->buyEvent($idcliente, $idevento, $classe, $num);
        if ($res) {
            $msg = "Acquisto effettuato correttamente!";
        } else {
            $msg = "Impossibile acquistare questi biglietti! Puoi effeettuare solo un ordine per evento!";
        }
    } else {
        if (($max_biglietti - $num_biglietti)>0){
            $tot = ($max_biglietti - $num_biglietti);
            $msg = "Impossibile acquistare questi biglietti! Puoi acquistarne solo ".$tot;
        } else {
            $msg = "Impossibile acquistare questi biglietti! Evento sold out";
        }
    }
    $soldout = true;
    foreach ($dbh->getClassesByEvent($idevento)[0] as $classe){
        if ($dbh->ticketsSoldEvent($idevento, $classe)[0]['COUNT(*)'] < $dbh->numTicketsEvent($idevento, $classe)[0]['Quantita']) {
            $soldout = false;
        }
    }
    if ($soldout) {
        $res = $dbh->eventSoldOut($idevento);
    }
    header("location: login.php?formmsg=" . $msg);
}
?>