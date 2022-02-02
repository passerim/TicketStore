        <div class="container">
            <div class="col-md-12">
                <div class="home-article mt-5 row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <?php if (count($templateParams["evento"]) == 0) : ?>
                            <article>
                                <p>Evento non presente</p>
                            </article>
                        <?php
                        else :
                            $evento = $templateParams["evento"][0];
                        ?>
                            <article>
                                <?php if (isset($_SESSION["idcliente"])) : ?>
                                    <form action="processa-acquisto.php" id="acquista" method="POST" enctype="multipart/form-data">
                                    <?php endif; ?>
                                    <header>
                                        <strong class="d-inline-block mb-2 text-primary">
                                            <?php
                                            foreach ($dbh->getCategoryByEvent($evento["IdEvento"]) as $category) :
                                                echo " ● " . $category['Nome'];
                                            endforeach;
                                            ?>
                                        </strong>
                                        <h2><?php echo $evento["Nome"]; ?></h2>
                                        <p><?php echo $evento["Data"]; ?> - <?php echo $evento["Luogo"]; ?></p>
                                    </header>
                                    <section>
                                        <div class="card-text mb-1" style="word-wrap: break-word;">
                                            <div class="col-auto eventimg d-lg-block">
                                                <img src="<?php echo UPLOAD_DIR . $evento["Immagine"]; ?>" alt="Immagine di copertina dell'evento" style="width: 100%;  object-fit: fill;">
                                            </div>
                                            <?php echo $evento["Descrizione"]; ?>
                                        </div>
                                        <div>Evento organizzato da: <br> <?php echo $dbh->getOrganizer($evento["IdEvento"])[0]["Email"]; ?></div>
                                    </section>
                                    <?php if (isset($_SESSION["idcliente"]) && (!isset($templateParams["buy"]) || $templateParams["buy"] == true) && $dbh->organizerActive($evento["IdOrganizzatore"])) : ?>
                                        <footer class="form-inline mt-5 d-flex justify-content-end">
                                            <label class="my-1 mr-2" for="numerobiglietti">Classe</label>
                                            <select class="custom-select my-1 mr-sm-2" id="classeevento" name="classeevento" form="acquista">
                                                <?php foreach ($dbh->getClassesByEvent($evento["IdEvento"]) as $classe) : ?>
                                                    <option value="<?php echo $classe['NomeClasse']; ?>"><?php echo $classe['NomeClasse']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label class="my-1 mr-2" for="numerobiglietti">Biglietti</label>
                                            <select class="custom-select my-1 mr-sm-2" id="numerobiglietti" name="numbiglietti" form="acquista">
                                                <option selected value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                            </select>
                                            <button type="submit" class="btn btn-primary my-1">Acquista</button>
                                            <input type="hidden" name="idevento" value="<?php echo $evento["IdEvento"]; ?>" />
                                            <input type="hidden" name="action" value="1" />
                                        </footer>
                                    </form>
                                <?php endif; ?>
                            </article>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>