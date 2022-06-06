<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Manager - <?= $pageTitle ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css' />
    <style type="text/css">
        .container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .hide {
            display: none;
        }
    </style>
</head>

<body>
    <!-- 1 - Étape du workflow Ajax On écoute les forms html, ici présents -->
    <main class='container'>
        <h1>Dashboard <?= $pageTitle ?></h1>
        <div class="container">
            
            <section id="authentication">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Authentification d'un utilisateur</h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            <div class="result-login hide"></div>
                            <div class="auth-info"></div>
                        </h6>
                        <form id="auth">
                            <input type="hidden" name="action" value="auth">
                            <p class="card-text">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">@</span>
                                </div>
                                <input type="text" class="form-control" name="email" placeholder="Email" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="text" class="form-control" name="password" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1">
                            </div>
                            </p>
                            <button class="btn btn-large btn-primary" id="login">Se Connecter</button>
                        </form>

                        <a href="#" class="hide btn btn-large btn-danger" id="logout">Se Déconnecter</a>
                    </div>
                </div>
            </section>
            <section id="recherche" class="hide">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Recherche d'un utilisateur</h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            <div class="error-search"></div>
                        </h6>
                        <p class="card-text">
                        <form id="search" class="form-inline my-2 my-lg-0">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                        </form>
                        </p>
                    </div>
                    <section class="result-search">
                        <ul></ul>
                    </section>
                </div>
            </section>
            <section id="suppression" class="hide">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Suppression d'utilisateurs</h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            <div class="error-delete"></div>
                        </h6>
                        <p class="card-text">
                        <form id="delete">
                            <input type="hidden" name="action" value="delete">
                            <div id="delUserList">
                                <ul></ul>
                            </div>
                            <button class="btn btn-large btn-danger">Supprimer en masse</button>
                        </form>
                        </p>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <script type="module" src="js/app.js"></script>
</body>

</html>