        <div class="container">
            <div class="nav-scroller">
                <nav class="nav d-flex justify-content-between">
                    <?php foreach ($templateParams["categorie"] as $category) : ?>
                        <a class="p-3 font-weight-bolder text-muted" style="color: #343a40!important;" href="eventi-categoria.php?id=<?php echo $category["Nome"]; ?>"><?php echo $category["Nome"] ?></a>
                    <?php endforeach; ?>
                </nav>
            </div>
        </div>

        <?php if (isset($templateParams["eventicasuali"]) and !isset($templateParams["titolo_pagina"])) : ?>
            <div class="container">
                <div class="jumbotron p-4 p-md-5 text-white rounded bg-dark" style="max-height: 500px;">
                    <div class="col-md-12 px-0">
                        <div class="row no-gutters overflow-hidden flex-md-row h-md-250 position-relative">
                            <section class="col p-4 d-flex flex-column position-static">
                                <header>
                                    <h2 class="mb-2 font-italic" style="font-size: 2.5rem;"><?php echo $templateParams["eventicasuali"][0]["Nome"]; ?></h2>
                                </header>
                                <p class="lead mb-2"><?php echo $templateParams["eventicasuali"][0]["Anteprima"]; ?></p>
                                <footer class="mt-auto"><a href="evento.php?id=<?php echo $templateParams["eventicasuali"][0]["IdEvento"]; ?>" class="text-white font-weight-bold lead">Vedi evento</a></footer>
                            </section>
                            <div class="col-auto d-none d-lg-block" style="max-width: 60%;">
                                <img class="jmbimg" src="<?php echo UPLOAD_DIR . $templateParams["eventicasuali"][0]["Immagine"]; ?>" alt="Immagine copertina dell'evento" style="object-fit: contain; max-height: 400px;" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

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
                                <div class="home-article row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative" style="max-height: 500px;">
                                    <article class="col p-4 d-flex flex-column position-static">
                                        <strong class="d-inline-block mb-2 text-primary">
                                            <?php
                                            foreach ($dbh->getCategoryByEvent($evento["IdEvento"]) as $category) :
                                                echo " ● " . $category['Nome'];
                                            endforeach;
                                            ?>
                                        </strong>
                                        <h3 class="mb-1"><a class="text-dark" href="evento.php?id=<?php echo $evento["IdEvento"]; ?>"><?php echo $evento["Nome"]; ?></a></h3>
                                        <div class="mb-1 text-muted"><?php echo $evento["Data"]; ?> - <?php echo $evento["Luogo"]; ?></div>
                                        <div class="card-text mb-1" style="word-wrap: break-word;">
                                            <div class="col-auto d-lg-block" style="max-width: 60%; height: fit-content; float: right;">
                                                <img src="<?php echo UPLOAD_DIR . $evento["Immagine"]; ?>" alt="Immagine copertina dell'evento" style="width: 100%; max-height: 300px; object-fit: contain;">
                                            </div>
                                            <?php echo $evento["Anteprima"]; ?>
                                        </div>
                                        <a href="evento.php?id=<?php echo $evento["IdEvento"]; ?>" class="mt-auto">Vedi evento</a>
                                    </article>
                                    <?php $i += 1; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="js/home-view.js?v=<?= time(); ?>"></script>