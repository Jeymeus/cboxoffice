<?php


// Récupérer le terme de recherche depuis le formulaire
$search_term = isset($_GET['search']) ? $_GET['search'] : '';
dump($search_term);

function userSearchByGet($search_term)
{
    global $db;

    // Nettoyer et sécuriser le terme de recherche
    $search_term_cleaned = htmlspecialchars(strip_tags($search_term));

    // Construire et exécuter la requête préparée
    $sql = "SELECT * FROM movies WHERE title LIKE ?";
    $query = $db->prepare($sql);
    $query->execute(["%$search_term_cleaned%"]);
    $search = $query->fetchAll();

    return $search;
}
$search = (userSearchByGet($search_term));


dump($search);
die('toto');
