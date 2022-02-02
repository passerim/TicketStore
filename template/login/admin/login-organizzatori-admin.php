<div class="container mt-3 mb-2">
    <section>
        <div class="pl-3 pr-3 mb-3 d-flex justify-content-between">
            <h2>Organizzatori</h2>
            <?php if (isset($templateParams["formmsg"])) : ?>
                <p><?php echo $templateParams["formmsg"]; ?></p>
            <?php endif; ?>
        </div>
        <?php if (isset($templateParams["organizzatori"])) : ?>
            <div class="container justify-content-between">
                <?php
                $i = 0;
                while ($i < count($templateParams["organizzatori"])) :
                ?>
                    <div class="row justify-content-center">
                        <?php foreach (array_slice($templateParams["organizzatori"], $i, $i + 2) as $organizzatore) : ?>
                            <div class="col-md-6">
                                <article class="home-article row no-gutters border rounded overflow-hidden flex-md-row mb-2 shadow-sm h-md-250 position-relative" style="max-height: 500px;">
                                    <form action="processa-organizzatore.php" style="width: 100%;" method="POST" enctype="multipart/form-data">
                                        <div class="col p-3 d-flex flex-column position-static">
                                            <h4 class="mb-0">Nome: <?php echo $organizzatore["Nome"]; ?></h4>
                                            <div class="card-text" style="word-wrap: break-word;">
                                                <ul class='mb-0'>
                                                    <li>ID: <?php echo $organizzatore["IdOrganizzatore"]; ?></li>
                                                    <li>Email: <?php echo $organizzatore["Email"]; ?></li>
                                                    <li>Indirizzo: <?php echo $organizzatore["Indirizzo"]; ?></li>
                                                    <li>Città: <?php echo $organizzatore["Citta"]; ?></li>
                                                    <li>Descrizione: <?php echo $organizzatore["Descrizione"]; ?></li>
                                                </ul>
                                            </div>
                                            <div class="d-flex flex-row-reverse justify-content-between">
                                                <input type="submit" class="btn p-0 btn-link" name="submit" value="Cancella" />
                                            </div>
                                            <input type="hidden" name="idorganizzatore" value="<?php echo $organizzatore["IdOrganizzatore"]; ?>" />
                                            <input type="hidden" name="action" value="3" />
                                        </div>
                                    </form>
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