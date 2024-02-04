<?php
$movie = detailsMovie();
$categories = category();

if (!empty($movie)) {
    $data['movie'] = $movie;
    $durationMovie = durationMovie($movie->duration);
    $data['duration'] = $durationMovie;
    $data['categories'] = $categories;
} else {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 NOT FOUND');
    die('404 - Page not found');
}
