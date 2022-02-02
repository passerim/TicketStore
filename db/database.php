<?php
class DatabaseHelper
{
    private $db;

    public function __construct($servername, $username, $password, $dbname)
    {
        $this->db = new mysqli($servername, $username, $password, $dbname);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public function getRandomEvents($n)
    {
        $query = "SELECT * FROM evento WHERE Stato = 1 ORDER BY RAND() LIMIT ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $n);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getEvents($n = -1)
    {
        $query = "SELECT * FROM evento WHERE Stato = 1 ORDER BY Data DESC";
        if ($n > 0) {
            $query .= " LIMIT ?";
        }
        $stmt = $this->db->prepare($query);
        if ($n > 0) {
            $stmt->bind_param('i', $n);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getEventsOrderedId($n = -1)
    {
        $query = "SELECT * FROM evento ORDER BY IdEvento";
        if ($n > 0) {
            $query .= " LIMIT ?";
        }
        $stmt = $this->db->prepare($query);
        if ($n > 0) {
            $stmt->bind_param('i', $n);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getEventsByCategory($nomecategoria)
    {
        $query = "SELECT E.IdEvento, E.Luogo, E.Nome, E.Immagine, E.Anteprima, E.Data FROM evento E, afferenza A WHERE E.Stato = 1 AND A.Nome=? AND E.IdEvento=A.IdEvento ORDER BY Data DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $nomecategoria);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getEventsByOrganizerId($id)
    {
        $query = "SELECT * FROM evento WHERE IdOrganizzatore=? ORDER BY IdEvento";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getEventsByClientId($id)
    {
        $query = "SELECT E.IdEvento, E.Nome, E.Luogo, E.Data, E.Descrizione, E.Anteprima, E.Immagine, E.IdOrganizzatore, COUNT(*), O.Importo FROM evento E JOIN ordine O JOIN composizione C ON (E.IdEvento = O.IdEvento AND C.IdOrdine = O.IdOrdine) WHERE O.IdUtente=? GROUP BY E.IdEvento ORDER BY E.IdEvento";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getEventById($id)
    {
        $query = "SELECT E.IdEvento, E.Luogo, E.Anteprima, E.Nome, E.Immagine, E.Descrizione, E.Data, E.IdOrganizzatore, (SELECT GROUP_CONCAT(A.Nome) FROM afferenza A WHERE A.IdEvento=E.IdEvento GROUP BY A.IdEvento) as categorie FROM evento E WHERE E.IdEvento=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function approveEvent($idevento)
    {
        $query = "UPDATE evento SET Stato = 1 WHERE IdEvento = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idevento);
        return $stmt->execute();
    }

    public function getNonApprovedEvents()
    {
        $query = "SELECT * FROM evento WHERE Stato = 0 ORDER BY IdEvento";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function numTicketsEvent($id, $classe)
    {
        $query = "SELECT Quantita FROM classe_biglietto WHERE IdEvento = ? AND NomeClasse = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('is', $id, $classe);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function ticketsSoldEvent($id, $classe)
    {
        $query = "SELECT COUNT(*) FROM composizione C JOIN biglietto B On (C.Codice = B.Codice) WHERE B.IdEvento=? AND B.NomeClasse = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('is', $id, $classe);
        $stmt->execute();
        $result = $stmt->get_result();
        $res = $result->fetch_all(MYSQLI_ASSOC);
        return $res;
    }

    public function getCategories()
    {
        $query = "SELECT * FROM categoria";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCategoryByEvent($IdEvento)
    {
        $query = "SELECT Nome FROM afferenza WHERE IdEvento=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $IdEvento);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getStatusFromId($idstato)
    {
        $query = "SELECT Descrizione FROM stato_evento WHERE IdStato=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idstato);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function organizerActive($IdOrganizzatore)
    {
        $query = "SELECT Attivo FROM organizzatore WHERE IdOrganizzatore=? ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $IdOrganizzatore);
        $stmt->execute();
        $result = $stmt->get_result();
        $res = $result->fetch_all(MYSQLI_ASSOC);
        if ($res[0]["Attivo"] == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function insertOrganizer($Nome, $Email, $Password, $Citta, $Indirizzo, $Descrizione)
    {
        $query = "INSERT INTO organizzatore (Nome, Email, Password, Citta, Indirizzo, Descrizione, Attivo) VALUES (?, ?, ?, ?, ?, ?, 1)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssssss', $Nome, $Email, $Password, $Citta, $Indirizzo, $Descrizione);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function insertUser($nome, $cognome, $Email, $Password, $Citta, $indirizzo)
    {
        $query = "INSERT INTO utente (Nome, Cognome, Email, Password, Citta, Attivo, Indirizzo) VALUES (?, ?, ?, ?, ?, 1, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssssss', $nome, $cognome, $Email, $Password, $Citta, $indirizzo);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function insertEvent($Nome, $Descrizione, $Anteprima, $Luogo, $Data, $Immagine, $organizzatore)
    {
        $query = "INSERT INTO evento (Nome, Descrizione, Anteprima, Data, Luogo, Immagine, IdOrganizzatore) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssssssi', $Nome, $Descrizione, $Anteprima, $Data, $Luogo, $Immagine, $organizzatore);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function insertCategoryOfEvent($evento, $categoria)
    {
        $query = "INSERT INTO afferenza (IdEvento, Nome) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('is', $evento, $categoria);
        return $stmt->execute();
    }

    public function insertClassOfEvent($id, $classe, $prezzo, $quantita)
    {
        $query = "INSERT INTO classe_biglietto (IdEvento, NomeClasse, Prezzo, Quantita) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('isii', $id, $classe, $prezzo, $quantita);
        return $stmt->execute();
    }

    public function insertBiglietto($id, $classe)
    {
        $query = "INSERT INTO biglietto (IdEvento, NomeClasse) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('is', $id, $classe);
        return $stmt->execute();
    }

    public function updateEventOfOrganizer($IdEvento, $Nome, $Descrizione, $Anteprima, $Luogo, $Data, $Immagine, $organizzatore)
    {
        $query = "UPDATE evento SET Nome = ?, Descrizione = ?, Anteprima = ?, Immagine = ?, Luogo = ?, Data = ? WHERE IdEvento = ? AND IdOrganizzatore = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssssssii', $Nome, $Descrizione, $Anteprima, $Immagine, $Luogo, $Data, $IdEvento, $organizzatore);
        return $stmt->execute();
    }

    public function deleteEvent($IdEvento)
    {
        $query = "DELETE FROM afferenza WHERE IdEvento = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $IdEvento);
        $stmt->execute();
        $query = "DELETE FROM composizione WHERE Codice IN (SELECT Codice FROM biglietto WHERE IdEvento = ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $IdEvento);
        $stmt->execute();
        $query = "DELETE FROM biglietto WHERE IdEvento = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $IdEvento);
        $stmt->execute();
        $query = "DELETE FROM ordine WHERE IdEvento = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $IdEvento);
        $stmt->execute();
        $query = "DELETE FROM classe_biglietto WHERE IdEvento = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $IdEvento);
        $stmt->execute();
        $query = "DELETE FROM approvazione WHERE IdEvento = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $IdEvento);
        $stmt->execute();
        $query = "DELETE FROM evento WHERE IdEvento = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $IdEvento);
        $stmt->execute();
        return true;
    }

    public function deleteCategoryOfEvent($evento, $categoria)
    {
        $query = "DELETE FROM afferenza WHERE IdEvento = ? AND Nome = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('is', $evento, $categoria);
        return $stmt->execute();
    }

    public function deleteCategoriesOfEvent($evento)
    {
        $query = "DELETE FROM afferenza WHERE evento = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $evento);
        return $stmt->execute();
    }

    public function deleteOrganizer($organizzatore)
    {
        $query = "UPDATE organizzatore SET Attivo = 0 WHERE IdOrganizzatore = ? AND Attivo = 1";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $organizzatore);
        $stmt->execute();
        return true;
    }

    public function deleteClient($utente)
    {
        $query = "UPDATE utente SET Attivo = 0 WHERE IdUtente = ? AND Attivo = 1";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $utente);
        $stmt->execute();
        return true;
    }

    public function getOrganizers()
    {
        $query = "SELECT IdOrganizzatore, Email, Nome, Citta, Indirizzo, Descrizione FROM  organizzatore  WHERE Attivo=1 ORDER BY IdOrganizzatore";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getOrganizer($IdEvento)
    {
        $query = "SELECT IdOrganizzatore FROM evento WHERE IdEvento = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $IdEvento);
        $stmt->execute();
        $result = $stmt->get_result();
        $id = $result->fetch_all(MYSQLI_ASSOC);
        $id = $id[0]["IdOrganizzatore"];
        $query = "SELECT Email FROM organizzatore WHERE IdOrganizzatore = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAdmins()
    {
        $query = "SELECT Email FROM admin";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getClients()
    {
        $query = "SELECT IdUtente, Email, Nome, Cognome, Citta, Indirizzo FROM utente WHERE Attivo=1 GROUP BY Email, Nome ORDER BY IdUtente";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getClientsOfEvent($IdEvento)
    {
        $query = "SELECT Email FROM utente, utente_partecipa WHERE evento = ? AND IdUtente = utente";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $IdEvento);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getClassesByEvent($id)
    {
        $query = "SELECT NomeClasse FROM classe_biglietto WHERE IdEvento = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTicketsByClient($id, $idevento)
    {
        $query = "SELECT COUNT(*) FROM composizione C JOIN ordine O ON (C.IdOrdine = O.IdOrdine) WHERE O.IdUtente = ? AND O.IdEvento = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $id, $idevento);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getImportoByClient($id, $idevento)
    {
        $query = "SELECT Importo FROM ordine WHERE IdUtente = ? AND IdEvento = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $id, $idevento);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getEventStatus($idevento)
    {
        $query = "SELECT Descrizione FROM stato_evento WHERE IdStato = (SELECT Stato FROM evento WHERE IdEvento = ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idevento);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function buyEvent($idutente, $idevento, $classe, $num)
    {
        $query = "SELECT Prezzo FROM classe_biglietto WHERE IdEvento = ? AND NomeClasse = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('is', $idevento, $classe);
        $stmt->execute();
        $result = $stmt->get_result();
        $prezzo = $result->fetch_all(MYSQLI_ASSOC)[0]['Prezzo'] * $num;
        $data = date("Y-m-d");
        $query = "INSERT INTO ordine (IdEvento, IdUtente, Data, Importo) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iisi', $idevento, $idutente, $data, $prezzo);
        if ($stmt->execute()) {
            $query = "SELECT IdOrdine FROM ordine WHERE IdEvento=? AND IdUtente=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ii', $idevento, $idutente);
            $stmt->execute();
            $result = $stmt->get_result();
            $idordine = $result->fetch_all(MYSQLI_ASSOC)[0]['IdOrdine'];
            $query = "INSERT INTO composizione (Codice, IdOrdine) SELECT B.Codice, O.IdOrdine FROM biglietto B JOIN ordine O ON (B.IdEvento = O.IdEvento) WHERE (B.Codice) NOT IN (SELECT Codice FROM composizione) AND B.IdEvento = ? AND O.IdOrdine = ? LIMIT ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('iii', $idevento, $idordine, $num);
            $stmt->execute();
            return true;
        }
        return false;
    }

    function EmailDuplicated($Email)
    {
        $people = array(
            "admin" => "Email",
            "utente" => "Email",
            "organizzatore" => "Email"
        );
        foreach ($people as $key => $value) {
            if ($res = $this->db->prepare("SELECT $value FROM $key WHERE $value = ?")) {
                $res->bind_param('s', $Email);
                $res->execute();
                $res->store_result();
                $res->bind_result($id);
                $res->fetch();
                if (!is_null($id)) {
                    return true;
                }
            }
        }
        return false;
    }

    public function checkLogin($Email, $Password)
    {
        $query = "SELECT Email FROM amministratore WHERE Email = ? AND Password = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $Email, $Password);
        $stmt->execute();
        $result = $stmt->get_result();
        $ret = $result->fetch_all(MYSQLI_ASSOC);
        if (isset($ret[0]["Email"])) {
            $ret[0]["usertype"] = 0;
            return $ret;
        }
        $query = "SELECT IdOrganizzatore, Nome, Email FROM organizzatore WHERE Attivo=1 AND Email = ? AND Password = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $Email, $Password);
        $stmt->execute();
        $result = $stmt->get_result();
        $ret = $result->fetch_all(MYSQLI_ASSOC);
        if (isset($ret[0]["IdOrganizzatore"])) {
            $ret[0]["usertype"] = 1;
            return $ret;
        }
        $query = "SELECT IdUtente, Nome, Email FROM utente WHERE Attivo=1 AND Email = ? AND Password = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $Email, $Password);
        $stmt->execute();
        $result = $stmt->get_result();
        $ret = $result->fetch_all(MYSQLI_ASSOC);
        if (isset($ret[0]["IdUtente"])) {
            $ret[0]["usertype"] = 2;
            return $ret;
        }
    }

    public function eventSoldOut($idevento)
    {
        $query = "UPDATE evento SET Stato = 2 WHERE IdEvento = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idevento);
        return $stmt->execute();
    }

    public function isEventSoldOut($idevento)
    {
        $query = "UPDATE evento SET Stato = 2 WHERE IdEvento = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idevento);
        $res = $stmt->execute()[0]['Stato'];
        if ($res == 2) {
            return true;
        }
        return false;
    }
}
