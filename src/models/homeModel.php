<?php

/**
 * Retrieves movies created within the last week from the database.
 *
 *  * @return object 
 */
function getMovies()
{
    global $db;
    $sql = 'SELECT slug, title, poster FROM movies WHERE created >= DATE_SUB(NOW(), INTERVAL 1 WEEK) ORDER BY created DESC';
    $query = $db->prepare($sql);
    $query->execute();

    return $query->fetchAll();
}