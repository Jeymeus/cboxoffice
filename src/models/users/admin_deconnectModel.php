<?php 

unset($_SESSION['user']);
header('Location: ' . $router->generate('login'));
die;