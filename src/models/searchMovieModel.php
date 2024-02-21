<?php

/**
 * Searches for movies in the database based on the provided search term.
 *
 * @param string $search The search term entered by the user.
 * @return object 
 */
function userSearchMovies($search)
{
    global $db;

    $search_cleaned = htmlspecialchars(strip_tags($search));

    $sql = "SELECT * FROM movies WHERE title LIKE ?";
    $query = $db->prepare($sql);
    $query->execute(["%$search_cleaned%"]);
    $search = $query->fetchAll();

    return $search;
}





