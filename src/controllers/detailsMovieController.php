<?php
// Get movie details and categories
$movie = detailsMovie();
$categories = category();

if (!empty($movie)) {
    $data['movie'] = $movie;
    $durationMovie = durationMovie($movie->duration);
    $data['duration'] = $durationMovie;
    $data['categories'] = $categories;
} else {
    // If movie details are empty, return a 404 error
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 NOT FOUND');
    // Stop script execution and display a 404 error message
    die('404 - Page not found');
}
?>
