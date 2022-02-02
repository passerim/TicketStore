<div class="container">
    <div class="row mt-5">
        <div class="col-12 col-md-6 offset-md-3">
        <?php if (isset($_GET["error"])) : ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Errore!</strong>
                    <?php
                    $res = intval($_GET['error']);
                    switch ($res) {
                        case -1:
                            echo "La email seguente è già collegata ad un account!";
                            break;
                        default:
                            echo 'Errore non riconosciuto: Error#' . $res;
                            break;
                    };
                    ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            <div class="alert alert-danger alert-js" role="alert" style="display: None">
                <p>Dati inseriti non corretti</p>
            </div>
            <section id="schermata_di_registrazione">
                <form id="inputform" method="POST" action="processa-cliente.php" onsubmit="return validateForm()" enctype="multipart/form-data">
                    <fieldset class="mt-2" id="registrazione">
                        <legend class="w-50 text-center">Registrazione Cliente</legend>
                        <div class="card card-body">
                            <div class="form-group"> 
                                <label for="nome">Nome</label>
                                <input type="text" name="nome" class="form-control" id="nome" onfocusout="checkName();return false" placeholder="Inserisci Nome" required></input>
                                <span id="confirmName" class="confirmMessage"></span>
                            </div>
                            <div class="form-group">
                                <label for="cognome">Cognome</label>
                                <input type="text" name="cognome" class="form-control" id="cognome" onfocusout="checkSurname();return false" placeholder="Inserisci Cognome" required></input>
                                <span id="confirmSurname" class="confirmMessage"></span>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Inserisci Email" onfocusout="checkEmail(); return false;" required></input>
                                <span id="confirmEmail" class="confirmMessage"></span>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" id="password" minlength="5" placeholder="Inserisci Password" onfocusout="controlPassword(); return false;" required></input>
                                <span id="confirmMessage" class="confirmMessage"></span>
                            </div>
                            <div class="form-group">
                                <label for="ripeti_password">Ripeti Password</label>
                                <input type="password" name="ripeti_password" class="form-control" id="ripeti_password" minlength="5" placeholder="Ripeti Password" onkeyup="controlPassword(); return false;" required></input>
                            </div>
                            <div class="form-group">
                                <label for="indirizzo">Indirizzo</label>
                                <input type="text" name="indirizzo" class="form-control" id="indirizzo" placeholder="Inserisci Indirizzo" required>
                            </div>
                            <div class="form-group">
                                <label for="città">Città</label>
                                <input type="text" name="città" class="form-control" id="città" placeholder="Inserisci Città" onfocusout="checkCity(); return false;" required></input>
                                <span id="confirmCity" class="confirmMessage"></span>
                            </div>
                        </div>
                    </fieldset>
                    <div class="text-center mt-3 mb-5">
                        <input type="button" value="Torna al Login" onClick="location.href='login.php'" name="Torna al Login" class="btn btn-primary" style="background-color: #343a40; border-width: 0;"></input>
                        <input type="submit" class="btn btn-primary" id="submit" value="Avanti" style="background-color: #343a40; border-width: 0;"></input>
                        <input type="hidden" name="action" value="1" /></input>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
<script src="js/name.js"></script>
<script src="js/surname.js"></script>
<script src="js/city.js"></script>
<script src="js/control_password.js"></script>
<script src="js/check_email.js"></script>
<script>
    function validateForm() {
        if (checkName() == false) {
            alert("Il nome è errato!");
            return false;
        }
        if (checkSurname() == false) {
            alert("Il cognome è errato!");
            return false;
        }
        if (checkEmail() == false) {
            alert("L' email è errata!");
            return false;
        }
        if (checkCity() == false) {
            alert("La città è errata!");
            return false;
        }
        if (controlPassword() == false) {
            alert("Una delle due password è errata!");
            return false;
        }
    }
</script>