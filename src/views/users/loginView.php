<?php get_header('Se connecter', 'login'); ?>

<style>
    html,
    body,
    .vertical-center {
        height: 100%;
    }


    .form-signin {
        max-width: 330px;
        padding: 1rem;
    }

    .form-signin .form-floating:focus-within {
        z-index: 2;
    }

    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }

    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
</style>

<div class="container vertical-center">
    <div class="d-flex align-items-center py-4 bg-body-tertiary vertical-center">
        <form class="form-signin w-100 m-auto" method="post">
            <h1 class="h3 mb-3 fw-normal text-center">Se connecter</h1>
            <div class="form-floating">
                <?php $error = checkEmptyFields('email'); ?>
                <input type="email" class="form-control <?= $error['class'] ?>" id="floatingInput" name="email" placeholder="Email">
                <label for="floatingInput">Email</label>
                <?= $error['message']; ?>
            </div>
            <div class="form-floating ">
                <input type="text" class="form-control d-none" id="bot_field" name="bot_field" placeholder="Enterprise">
                <label for="bot_field"></label>
            </div>
            <div class="form-floating">
                <?php $error = checkEmptyFields('pwd'); ?>
                <input type="password" class="form-control <?= $error['class'] ?>" id="floatingPassword" name="pwd" placeholder="Mot de passe">
                <label for="floatingPassword">Mot de passe</label>
                <?= $error['message']; ?>
            </div>
            <button class="btn btn-primary w-100 py-2" type="submit">Connexion</button>
            <p class="mt-4 mb-3 text-body-secondary text-center">
                <a href="<?= $router->generate('lostPassword'); ?>">Mot de passe oublié ?</a>
            </p>
            <p class="mt-4 mb-3 text-body-secondary text-center">
                <a href="<?= $router->generate('home'); ?>">Retour à l'accueil</a>
            </p>
                
        </form>
    </div>
</div>

<!-- 
    Pour protéger le site : au moins la moitié à ajouter : 
    Logout timer
    max attempts (vérifie le nombre de connexion à la minute par IP )
    honeypot
    lastdate
    2FA
    Captcha
    lostpwd
 -->


<?php get_footer('login'); ?>