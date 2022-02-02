        <div class="container mt-3  mb-2">
            <section>
                <div class="pl-3 pr-3 mb-3 d-flex justify-content-between">
                    <h2>Eventi</h2>
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
                            <div class="row justify-content-center">
                                <?php foreach (array_slice($templateParams["eventi"], $i, $i + 2) as $evento) : ?>
                                    <div class="col-md-6">
                                        <article class="home-article row no-gutters border rounded overflow-hidden flex-md-row mb-2 shadow-sm h-md-250 position-relative" style="max-height: 600px;">
                                            <form action="processa-evento.php" method="POST" style='width: 100%;' enctype="multipart/form-data">
                                                <div class="col p-3 d-flex flex-column position-static" style="height: 100%;">
                                                    <h5 class="m-0">Nome: <?php echo $evento["Nome"]; ?></h5>
                                                    <div class="card-text" style="word-wrap: break-word;">
                                                        <ul class="mb-0">
                                                            <li>ID: <?php echo $evento["IdEvento"]; ?></li>
                                                            <li>Stato: <?php echo $dbh->getStatusFromId($evento["Stato"])[0]['Descrizione']; ?></li>
                                                            <li>Data: <?php echo $evento["Data"]; ?></li>
                                                            <li>Luogo: <?php echo $evento["Luogo"]; ?></li>
                                                            <li>Evento organizzato da: <br> <?php echo $dbh->getOrganizer($evento["IdEvento"])[0]["Email"]; ?></li>
                                                        </ul>
                                                    </div>
                                                    <div class="d-flex flex-row-reverse justify-content-between">
                                                        <input type="submit" class="btn p-0 mt-auto btn-link" name="submit" value="Cancella" />
                                                    </div>
                                                    <input type="hidden" name="idevento" value="<?php echo $evento["IdEvento"]; ?>" />
                                                    <input type="hidden" name="action" value="3" />
                                                </div>
                                            </form>
                                        </article>
                                        <?php
                                        $i += 1;
                                        ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </section>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="js/home-view.js"></script>