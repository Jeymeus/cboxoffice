<?php
$router->addMatchTypes(['url' => '[a-z0-9]+(?:-[a-z0-9]+)*']);



//Movies
$router->map('GET', '/','home', 'home');
$router->map('GET', '/recherche','search', 'search');
$router->map('GET', '/films/[url:slug]','detailsMovie', 'details');


//Pages
$router->map('GET', '/politique-confidentialite','privacy', 'privacy');
$router->map('GET', '/mention-legales','legal-notice', 'legal-notice');



