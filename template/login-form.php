        <div class="container">
            <?php if (isset($_GET["formmsg"])) : ?>
                <p><?php echo $_GET["formmsg"]; ?></p>
            <?php endif; ?>
            <form action="#" method="POST" class="mt-5 mb-2">
                <?php if (isset($templateParams["errorelogin"])) : ?>
                    <div style="width: 70%; margin-left: 15%;" class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Errore!</strong> <?php echo $templateParams["errorelogin"]; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <body class="text-center">
                    <section>
                        <form class="form-signin text-center">
                            <h2 class="h1 text-center mb-3 font-weight-normal">Accesso</h2>
                            <label for="email" class="sr-only">Email</label>
                            <input style="margin-left: 25%; width: 50%" type="email" id="email" name="email" class="mt-1 form-control" placeholder="Email" required autofocus>
                            <label for="password" class="sr-only">Password</label>
                            <input style="margin-left: 25%; width: 50%" type="password" id="password" name="password" class="mt-1 form-control" placeholder="Password" required>
                            <button class="mt-4 btn btn-lg btn-primary btn-block" type="submit" style="background-color: #343a40; border-color: #343a40; margin-left: 25%; width: 50%;">Accedi</button>
                        </form>
                    </section>
                </body>
            </form>
            <div class="text-center mb-5">
                <p>Non hai un account? Registrati <a href="/TicketStoreDB/signup.php?ucat=cl">come Cliente</a></br>oppure <a href="/TicketStoreDB/signup.php?ucat=org">come Organizzatore</a></p>
            </div>
        </div>