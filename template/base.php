<!doctype html>
<html lang="it">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css?v=<?= time(); ?>">

    <title><?php echo $templateParams["titolo"]; ?></title>
</head>

<body>
    <header class="page-header">
        <nav class="navbar d-flex">
            <h1 class="text-monospace ml-2"><a class="blog-header-logo text-light" href="/TicketStoreDB"><em>TICKET</em><sub>STORE</sub></a></h1>
            <div class="mr-2">
                <?php if (!isset($_SESSION["idorganizzatore"]) && !isset($_SESSION["idcliente"]) && !isset($_SESSION["idadmin"])) : ?>
                    <a class="btn btn-sm btn-light" href="/TicketStoreDB/login.php">Accedi</a>
                <?php elseif (isset($_SESSION["idorganizzatore"])) : ?>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $_SESSION["nome"]; ?>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="/TicketStoreDB/login.php">Profilo</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/TicketStoreDB/index.php?logout=1">Esci</a>
                        </div>
                    </div>
                <?php elseif (isset($_SESSION["idadmin"])) : ?>   
                    <div class="btn-group">
                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Admin: <?php echo $_SESSION["nome"]; ?>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="/TicketStoreDB/login.php">Eventi</a>
                            <a class="dropdown-item" href="/TicketStoreDB/login.php?page=1">Organizzatori</a>
                            <a class="dropdown-item" href="/TicketStoreDB/login.php?page=2">Clienti</a>
                            <a class="dropdown-item" href="/TicketStoreDB/login.php?page=3">Approva Eventi</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/TicketStoreDB/index.php?logout=1">Esci</a>
                        </div>
                    </div>
                <?php elseif (isset($_SESSION["idcliente"])) : ?>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $_SESSION["nome"]; ?>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="/TicketStoreDB/login.php">Eventi</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/TicketStoreDB/index.php?logout=1">Esci</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </nav>
    </header>
    <main>
        <?php
        if (isset($templateParams["nome"])) {
            require($templateParams["nome"]);
        }
        ?>
    </main>
    <footer class="blog-footer">
        <div class="col-12 text-center pt-1">
            <p>© Copyright 2020 TicketStore - Tutti i diritti riservati.</p>
            <p><a href="#">Torna su</a><em style="font-size: bigger;"> ● </em><a href="./info.php">Info</a></p>
        </div>
    </footer>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>