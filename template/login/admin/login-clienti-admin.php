<div class="container mt-3  mb-2">
    <section>
        <div class="pl-3 pr-3 mb-3 d-flex justify-content-between">
            <h2>Clienti</h2>
            <?php if (isset($templateParams["formmsg"])) : ?>
                <p><?php echo $templateParams["formmsg"]; ?></p>
            <?php endif; ?>
        </div>
        <?php if (isset($templateParams["clienti"])) : ?>
            <div class="container justify-content-between">
                <?php
                $i = 0;
                while ($i < count($templateParams["clienti"])) :
                ?>
                    <div class="row justify-content-center">
                        <?php foreach (array_slice($templateParams["clienti"], $i, $i + 3) as $cliente) : ?>
                            <div class="col-md-4">
                                <article class="home-article no-gutters border rounded overflow-hidden flex-md-row mb-2 shadow-sm position-relative">
                                    <form action="processa-cliente.php" style="width: 100%;" method="POST" enctype="multipart/form-data">
                                        <div class="col p-3 d-flex flex-column position-static">
                                            <h5 class="mb-0">ID: <?php echo $cliente["IdUtente"]; ?></h5>
                                            <div class="card-text" style="word-wrap: break-word;">
                                                <ul class="mb-0">
                                                    <li>Nome: <?php echo $cliente["Nome"]; ?></li>
                                                    <li>Cognome: <?php echo $cliente["Cognome"]; ?></li>
                                                    <li>Email: <?php echo $cliente["Email"]; ?></li>
                                                    <li>Indirizzo: <?php echo $cliente["Indirizzo"]; ?></li>
                                                    <li>Città: <?php echo $cliente["Citta"]; ?></li>
                                                </ul>
                                            </div>
                                            <div class="d-flex flex-row-reverse justify-content-between">
                                                <input type="submit" class="btn p-0 btn-link" name="submit" value="Cancella" />
                                            </div>
                                            <input type="hidden" name="idcliente" value="<?php echo $cliente["IdUtente"]; ?>" />
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