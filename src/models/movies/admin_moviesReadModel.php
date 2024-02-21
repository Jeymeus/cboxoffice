<?php

/**
 * Retrieves all movies from the database.
 *
 * @return array Returns an array containing all movies.
 */
$sql = 'SELECT * FROM movies';
$query = $db->query($sql);
$movies = $query->fetchAll(PDO::FETCH_ASSOC);

?>