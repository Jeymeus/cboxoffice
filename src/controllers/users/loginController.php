<?php

if (!empty($_SESSION['sleep'])) {
   sleep(5);
   unset($_SESSION['sleep']);
}


if (!isset($_SESSION['attempts'])) {
   $_SESSION['attempts'] = 0;
}

if (!empty($_POST['bot_field'])) {
   alert('Bot Spoted', 'success');
}

if ($_SESSION['attempts'] <= 3) {
   if (!empty($_POST['email']) && !empty($_POST['pwd'])) {

      $accessUser = checkUserAccess();

      if ($accessUser !== false) {
         $_SESSION['attempts'] = 0;
         $_SESSION['user'] = [
            'id' => $accessUser,
            'lastLogin' => date('Y-m-d H:i:s')
         ];
         saveLastLogin($accessUser);
         alert('Connexion réussie', 'success');
         header('Location: ' . $router->generate('users'));
         die;
      } else {
         $_SESSION['attempts']++;
         alert('Identifiants incorrects', 'danger');
      }
   }
} else {
   alert('Trop de tentatives de connexion. Veuillez réessayer dans 30 secondes.', 'danger');
   unset($_SESSION['attempts']);
   $_SESSION['sleep'] = true;
}
