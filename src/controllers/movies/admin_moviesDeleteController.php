<?php

// Check if the 'movieId' parameter is present 
if (isset($_GET['movieId'])) {
    $movieIdToDelete = $_GET['movieId'];

    deleteMovie($movieIdToDelete);
}
?>
