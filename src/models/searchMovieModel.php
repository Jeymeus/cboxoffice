<?php

function userSearchMovies($search)
{
    global $db;

    // Nettoyer et sécuriser le terme de recherche
    $search_cleaned = htmlspecialchars(strip_tags($search));

    // Construire et exécuter la requête préparée
    $sql = "SELECT * FROM movies WHERE title LIKE ?";
    $query = $db->prepare($sql);
    $query->execute(["%$search_cleaned%"]);
    $search = $query->fetchAll();

    return $search;
}





