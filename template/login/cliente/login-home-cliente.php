        <div class="container mt-3">
            <section>
                <div class="pl-3 pr-3 mb-3 d-flex justify-content-between">
                    <h2>Eventi Acquistati</h2>
                    <?php if (isset($templateParams["formmsg"])) : ?>
                        <p><?php echo $templateParams["formmsg"]; ?></p>
                    <?php endif; ?>
                </div>
                <?php if (isset($templateParams["eventi"])) : ?>
                    <div class="container justify-content-between">
                        <?php
                        $i = 0;
                        while ($i < count($templateParams["eventi"])) :
                        ?>
                            <div class="row mb-2 justify-content-center">
                                <?php foreach (array_slice($templateParams["eventi"], $i, $i + 2) as $evento) : ?>
                                    <div class="col-md-6">
                                        <div class="home-article row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative" style="max-height: 500px;">
                                            <article class="col p-4 d-flex flex-column position-static">
                                                <h3 class="mb-1"><?php echo $evento["Nome"]; ?></h3>
                                                <div class="mb-1 text-muted"><?php echo $evento["Data"]; ?> - <?php echo $evento["Luogo"]; ?></div>
                                                <div class="card-text mb-1" style="word-wrap: break-word;">
                                                    <div class="col-auto d-lg-block" style="max-width: 60%; height: fit-content; float: right;">
                                                        <img src="<?php echo UPLOAD_DIR . $evento["Immagine"]; ?>" alt="Immagine di copertina dell'evento" style="width: 100%; max-height: 300px; object-fit: fill;">
                                                    </div>
                                                    <?php echo $evento["Anteprima"]; ?>
                                                </div>
                                                <div>Biglietti acquistati: <?php echo $evento['COUNT(*)']; ?></div>
                                                <div>Importo: <?php echo floatval($evento['Importo']); ?>  €</div>
                                                <div class="d-flex mt-auto flex-row-reverse justify-content-between">
                                                    <a class="btn mt-auto btn-link" href="evento.php?id=<?php echo $evento["IdEvento"]; ?>&from=cl">Vedi</a>
                                                </div>
                                            </article>
                                        </div>
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