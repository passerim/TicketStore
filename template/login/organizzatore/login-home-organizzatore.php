        <div class="container mt-3">
            <section>
                <div class="pl-3 pr-3 mb-3 d-flex justify-content-between">
                    <h2>Eventi Personali</h2>
                    <?php if (isset($templateParams["formmsg"])) : ?>
                        <p><?php echo $templateParams["formmsg"]; ?></p>
                    <?php endif; ?>
                    <p style="margin-top: 16px;"><a href="gestisci-eventi.php?action=1">Crea Evento</a></p>
                </div>
                <?php if (isset($templateParams["eventi"])) : ?>
                    <div class="container justify-content-between">
                        <?php if (isset($templateParams["titolo_pagina"])) : ?>
                            <h2 class="pb-3"><?php echo $templateParams["titolo_pagina"]; ?></h2>
                        <?php endif; ?>
                        <?php
                        $i = 0;
                        while ($i < count($templateParams["eventi"])) :
                        ?>
                            <div class="row mb-2 justify-content-center">
                                <?php foreach (array_slice($templateParams["eventi"], $i, $i + 2) as $evento) : ?>
                                    <div class="col-md-6">
                                        <article class="home-article row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative" style="max-height: 500px;">
                                            <div class="col p-4 d-flex flex-column position-static">
                                                <strong class="d-inline-block mb-2 text-primary">
                                                    <?php
                                                    foreach ($dbh->getCategoryByEvent($evento["IdEvento"]) as $category) :
                                                        echo " ● " . $category['Nome'];
                                                    endforeach;
                                                    ?></strong>
                                                <h3 class="mb-1"><?php echo $evento["Nome"]; ?></h3>
                                                <div class="mb-1 text-muted"><?php echo $evento["Data"]; ?> - <?php echo $evento["Luogo"]; ?></div>
                                                <div class="card-text mb-1" style="word-wrap: break-word;">
                                                    <div class="col-auto d-lg-block" style="max-width: 60%; height: fit-content; float: right;">
                                                        <img src="<?php echo UPLOAD_DIR . $evento["Immagine"]; ?>" alt="Immagine di copertina dell'evento" style="width: 100%; max-height: 300px; object-fit: fill;">
                                                    </div>
                                                    <?php echo $evento["Anteprima"]; ?>
                                                </div>
                                                <div>Stato: <?php echo $dbh->getEventStatus($evento['IdEvento'])[0]['Descrizione']; ?></div>
                                                <div class="d-flex mt-auto justify-content-between">
                                                    <a href="gestisci-eventi.php?action=2&id=<?php echo $evento["IdEvento"]; ?>" class="mt-auto">Modifica</a>
                                                    <a href="gestisci-eventi.php?action=3&id=<?php echo $evento["IdEvento"]; ?>" class="mt-auto">Cancella</a>
                                                </div>
                                            </div>
                                        </article>
                                        <?php
                                        $i += 1;
                                        ?>
                                    </div>
                                <?php
                                endforeach;
                                ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </section>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="js/home-view.js"></script>