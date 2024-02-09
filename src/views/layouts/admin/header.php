<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/public/images/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title><?= $title ?> | Admin</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-secondary mb-4" data-bs-theme="dark">
            <div class="container">
                <h1 class="navbar-brand">Espace Admin</h1>
                <a class="navbar-brand" href="<?= $router->generate('home'); ?>">Accueil</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $router->generate('users'); ?>"> Utilisateurs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $router->generate('addUser'); ?>">Ajouter Utilisateurs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $router->generate('library'); ?>"> Bibliothèque</a>
                        </li>
                        <li class="nav-item">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $router->generate('moviesEdit'); ?>">Ajouter | Modifier Films</a>
                        </li>
                    </ul>
                    <div class="navbar-text">
                        <a href="<?= $router->generate('deconnect') ?>" class="btn btn-danger">Déconnexion</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main class="container mb-4">
        <?php displayAlert(); ?>