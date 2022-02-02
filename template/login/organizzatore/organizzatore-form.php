        <?php
        $evento = $templateParams["evento"];
        $classe = $templateParams["classibiglietti"];
        $azione = getAction($templateParams["azione"])
        ?>
        <div class="container">
            <div class="col-md-12 mb-5 mt-5">
                <form action="processa-evento.php" method="POST" enctype="multipart/form-data">
                    <fieldset class="border border-light rounded overflow-hidden">
                        <legend class="w-50 text-center">
                            <h3><?php echo $azione; ?> Evento</h3>
                        </legend>
                        <?php if ($evento == null) : ?>
                            <p>Evento non trovato</p>
                        <?php else : ?>
                            <div class="card card-body shadow-sm">
                                <div class="form-group">
                                    <label for="titoloevento">Nome Evento:</label>
                                    <?php if ($templateParams["azione"] != 1) : ?>
                                        <input type="text" id="titoloevento" class="form-control" name="titoloevento" value="<?php echo $evento["Nome"]; ?>" />
                                    <?php else : ?>
                                        <input type="text" id="titoloevento" class="form-control" name="titoloevento" value="" placeholder="Nome Evento" />
                                    <?php endif; ?>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="dataevento">Data Evento:</label>
                                        <?php if ($templateParams["azione"] != 1) : ?>
                                            <input type="date" id="dataevento" class="form-control" name="dataevento" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $evento["Data"]; ?>" />
                                        <?php else : ?>
                                            <input type="date" id="dataevento" class="form-control" name="dataevento" min="<?php echo date("Y-m-d"); ?>" value="<?php echo date("Y-m-d"); ?>" />
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="luogoevento">Luogo Evento:</label>
                                        <?php if ($templateParams["azione"] != 1) : ?>
                                            <input type="text" id="luogoevento" class="form-control" name="luogoevento" value="<?php echo $evento["Luogo"]; ?>" />
                                        <?php else : ?>
                                            <input type="text" id="luogoevento" class="form-control" name="luogoevento" placeholder="Luogo Evento" />
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="testoevento">Descrizione Evento:</label>
                                    <?php if ($templateParams["azione"] != 1) : ?>
                                        <textarea id="testoevento" class="form-control" name="testoevento"><?php echo $evento["Descrizione"]; ?></textarea>
                                    <?php else : ?>
                                        <textarea id="testoevento" class="form-control" name="testoevento" placeholder="Descrizione Evento"></textarea>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="anteprimaevento">Anteprima Evento:</label>
                                    <?php if ($templateParams["azione"] != 1) : ?>
                                        <textarea id="anteprimaevento" class="form-control" name="anteprimaevento" maxlength="100"><?php echo $evento["Anteprima"]; ?></textarea>
                                    <?php else : ?>
                                        <textarea id="anteprimaevento" class="form-control" name="anteprimaevento" placeholder="Anteprima Evento" maxlength="100"></textarea>
                                    <?php endif; ?>
                                </div>
                                <?php if ($templateParams["azione"] == 1) : ?>
                                <div class="form-group">
                                    <legend>Biglietti</legend>
                                    <div class="d-flex">
                                        <div class="d-flex" style="width: 34%;">
                                            <label for="nomeclasse" style="margin-top: .5rem; margin-right: .5rem;">Classe:</label>
                                            <input type="text" id="nomeclasse" class="form-control" name="nomeclasse" placeholder="Classe Biglietti" />
                                        </div>
                                        <div class="d-flex" style="width: 33%;">
                                            <label for="maxbiglietti" style="margin-top: .5rem; margin-right: .5rem; margin-left: .5rem;">Quantità:</label>
                                            <input type="number" id="maxbiglietti" class="form-control" min="0" name="maxbiglietti" default="0" placeholder="Biglietti Disponibili" />
                                        </div>
                                        <div class="d-flex" style="width: 33%;">
                                            <label for="prezzobiglietti" style="margin-top: .5rem; margin-right: .5rem; margin-left: .5rem;">Prezzo:</label>
                                            <input type="number" id="prezzobiglietti" class="form-control" min="0" name="prezzobiglietti" default="0" placeholder="Prezzo" />
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <?php if ($templateParams["azione"] != 3) : ?>
                                        <label for="imgevento">Immagine Evento</label><input type="file" class="form-control mb-3 pt-3 pb-5" name="imgevento" id="imgevento" />
                                    <?php endif; ?>
                                    <?php if ($templateParams["azione"] != 1) : ?>
                                        <img src="<?php echo UPLOAD_DIR . $evento["Immagine"]; ?>" alt="" style="max-width: 100%;" />
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <p>Categorie:</p>
                                    <?php foreach ($templateParams["categorie"] as $categoria) : ?>
                                        <input type="checkbox" id="<?php echo $categoria["Nome"]; ?>" name="categoria_<?php echo $categoria["Nome"]; ?>" <?php
                                                                                                                                                            if ($templateParams["azione"] != 1 && in_array($categoria["Nome"], $evento["categorie"])) {
                                                                                                                                                                echo ' checked="checked" ';
                                                                                                                                                            }
                                                                                                                                                            ?> /><label for="<?php echo $categoria["Nome"]; ?>"><?php echo $categoria["Nome"]; ?></label>
                                    <?php endforeach; ?>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-lg btn-primary mr-3" style="background-color: #343a40; border-color: #343a40;" name="submit" value="<?php echo $azione; ?> Evento" />
                                    <a href="login.php">Annulla</a>
                                </div>

                            </div>
                            <?php if ($templateParams["azione"] != 1) : ?>
                                <input type="hidden" name="idevento" value="<?php echo $evento["IdEvento"]; ?>" />
                                <input type="hidden" name="categorie" value="<?php echo implode(",", $evento["categorie"]); ?>" />
                                <input type="hidden" name="oldimg" value="<?php echo $evento["Immagine"]; ?>" />
                            <?php endif; ?>

                            <input type="hidden" name="action" value="<?php echo $templateParams["azione"]; ?>" />
                        <?php endif; ?>
                    </fieldset>
                </form>
            </div>
        </div>