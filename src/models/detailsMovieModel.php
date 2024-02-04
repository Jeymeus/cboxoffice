<?php

function detailsMovie()
{

    global $db;

    $sql = 'SELECT * FROM movies where slug = :slug';
    $query = $db->prepare($sql);
    $query->execute(['slug' => $_GET['slug']]);

    return $query->fetch();
}

function category()
{
    global $db;

    $sql = 'SELECT c.name FROM movies m 
        JOIN movie_category mc ON m.id = mc.movie_id
        JOIN category c ON mc.category_id = c.id
        WHERE m.slug = :slug';
    $query = $db->prepare($sql);
    $query->execute(['slug' => $_GET['slug']]);
    $categories = $query->fetchAll(PDO::FETCH_COLUMN);

    return $categories;
}



function durationMovie($movie)
{
    // Récupérer la durée en minutes depuis la base de données (exemple : $durationFromDB)
    $durationFromDB = $movie; // Remplacez ceci par la valeur réelle de votre base de données

    // Calculer le nombre d'heures et de minutes
    $hours = floor($durationFromDB / 60);
    $minutes = fmod($durationFromDB, 60);

    // Afficher le résultat
    $duration = $hours . "h" . $minutes . " minutes";

    return $duration;
}
