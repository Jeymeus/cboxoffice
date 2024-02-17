<?php get_header('Editer un utilisateur', 'admin'); ?>


<style>
        .wrapper {
        max-width: 1550px;
        margin: 0 auto;
    }

    .form {
        width: 50%;
        border-collapse: collapse;
        margin-top: 20px;
    }

</style>
<div class="wrapper">
    <h1 class="mb-4">Editer un utilisateur</h1>
    <div class="form">
        <form action="" method="post" novalidate>
            <div class="mb-4">
                <?php $error = checkEmptyFields('email'); ?>
                <label for="email">Adresse email : *</label>
                <input type="email" name="email" id="email" value="<?= getValue('email') ?>" class="form-control <?= $error['class']; ?>">
                <?= $error['message']; ?>
                <?= $errorsMessage['email']; ?>
            </div>
            <div class="mb-4">
                <?php $error = checkEmptyFields('pwd'); ?>
                <label for="pwd">Mot de passe : *</label>
                <input type="password" name="pwd" id="pwd" class="form-control <?= $error['class']; ?>">
                <?= $error['message']; ?>
                <?= $errorsMessage['pwd']; ?>
            </div>
            <div class="mb-4">
                <?php $error = checkEmptyFields('pwd-confirm'); ?>
                <label for="pwdConfirm">Confirmartion du mot de passe : *</label>
                <input type="password" name="pwdConfirm" id="pwdConfirm" class="form-control <?= $error['class']; ?>">
                <?= $error['message']; ?>
                <?= $errorsMessage['pwdConfirm']; ?>
            </div>
            <div>
                <input type="submit" class="btn btn-success mb-3" value="Sauvegarder">
            </div>
            <div>
                <a href="http://movies.test/admin/utilisateurs/editer" class="btn btn-secondary ">Réinitialiser</a>
            </div>
            
        </form>
    </div>
</div>
    
    

<?php get_footer('admin'); ?>