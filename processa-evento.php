<?php
require_once 'bootstrap.php';

if ((!isOrganizerLoggedIn() && !isAdminLoggedIn()) || !isset($_POST["action"])) {
    header("location: login.php");
}

if ($_POST["action"] == 1) {
    //Inserisco
    $titoloevento = $_POST["titoloevento"];
    $testoevento = $_POST["testoevento"];
    $anteprimaevento = $_POST["anteprimaevento"];
    $dataevento = date("Y-m-d");
    $organizzatore = $_SESSION["idorganizzatore"];
    $dataevento = $_POST["dataevento"];
    $luogoevento = $_POST["luogoevento"];
    $categorie = $dbh->getCategories();
    $categorie_inserite = array();
    foreach ($categorie as $categoria) {
        if (isset($_POST["categoria_" . $categoria["Nome"]])) {
            array_push($categorie_inserite, $categoria["Nome"]);
        }
    }
    $classe = ($_POST["nomeclasse"]);
    $quantita = intval($_POST["maxbiglietti"]);
    $prezzo = intval($_POST["prezzobiglietti"]);
    list($result, $msg) = uploadImage(UPLOAD_DIR, $_FILES["imgevento"]);
    if ($result != 0) {
        $imgevento = $msg;
        $id = $dbh->insertEvent($titoloevento, $testoevento, $anteprimaevento, $luogoevento, $dataevento, $imgevento, $organizzatore);
        if ($id != false) {
            foreach ($categorie_inserite as $categoria) {
                $ris = $dbh->insertCategoryOfEvent($id, $categoria);
            }
            $ris = $dbh->insertClassOfEvent($id, $classe, $prezzo, $quantita);
            if ($ris != 0) {
                for ($counter = 0; $counter < $quantita; $counter = $counter + 1) {
                    $ris = $dbh->insertBiglietto($id, $classe);
                }
            }
            $msg = "Inserimento completato correttamente!";
        } else {
            $msg = "Errore in inserimento!";
        }
    }
    header("location: login.php?formmsg=" . $msg);
}

if ($_POST["action"] == 2) {
    //modifico
    $idevento = intval($_POST["idevento"]);
    $titoloevento = $_POST["titoloevento"];
    $testoevento = $_POST["testoevento"];
    $anteprimaevento = $_POST["anteprimaevento"];
    $organizzatore = $_SESSION["idorganizzatore"];
    $dataevento = $_POST["dataevento"];
    $luogoevento = $_POST["luogoevento"];
    if (isset($_FILES["imgevento"]) && strlen($_FILES["imgevento"]["name"]) > 0) {
        list($result, $msg) = uploadImage(UPLOAD_DIR, $_FILES["imgevento"]);
        if ($result == 0) {
            header("location: login.php?formmsg=" . $msg);
        }
        $imgevento = $msg;
    } else {
        $imgevento = $_POST["oldimg"];
    }
    $dbh->updateEventOfOrganizer($idevento, $titoloevento, $testoevento, $anteprimaevento, $luogoevento, $dataevento, $imgevento, $organizzatore);
    $categorie = $dbh->getCategories();
    $categorie_inserite = array();
    foreach ($categorie as $categoria) {
        if (isset($_POST["categoria_" . $categoria["Nome"]])) {
            array_push($categorie_inserite, $categoria["Nome"]);
        }
    }
    $categorievecchie = explode(",", $_POST["categorie"]);
    $categoriedaeliminare = array_diff($categorievecchie, $categorie_inserite);
    foreach ($categoriedaeliminare as $categoria) {
        $ris = $dbh->deleteCategoryOfEvent($idevento, $categoria);
    }
    $categoriedainserire = array_diff($categorie_inserite, $categorievecchie);
    foreach ($categoriedainserire as $categoria) {
        $ris = $dbh->insertCategoryOfEvent($idevento, $categoria);
    }
    $msg = "Modifica completata correttamente!";
    header("location: login.php?formmsg=" . $msg);
}

if ($_POST["action"] == 3) {
    //cancello
    $idevento = $_POST["idevento"];
    $dbh->deleteEvent($idevento);
    $msg = "Cancellazione completata correttamente!";
    header("location: login.php?formmsg=" . $msg);
}

if ($_POST["action"] == 4) {
    $idevento = intval($_POST["idevento"]);
    $res = $dbh->approveEvent($idevento);
    if ($res) {
        $msg = "Evento approvato!";
    } else {
        $msg = "Modifica non riuscita!";
    }
    header("location: login.php?formmsg=" . $msg);
}
