<?php

/**
 * Retrieves details of a movie based on its slug.
 *
 * @return mixed Returns an associative array containing details of the movie if found, or null otherwise.
 */
function detailsMovie()
{

    global $db;

    $sql = 'SELECT * FROM movies where slug = :slug';
    $query = $db->prepare($sql);
    $query->execute(['slug' => $_GET['slug']]);

    return $query->fetch();
}

/**
 * Retrieves categories associated with a movie based on its slug.
 *
 * @return array Returns an array of categories associated with the movie.
 */
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


/**
 * Converts duration in minutes to hours and minutes format.
 *
 * @param int $movie The duration of the movie in minutes.
 * @return string The duration of the movie in hours and minutes format.
 */
function durationMovie($movie)
{
    $durationFromDB = $movie; 
    $hours = floor($durationFromDB / 60);
    $minutes = fmod($durationFromDB, 60);
    $duration = $hours . "h" . $minutes . " minutes";

    return $duration;
}
