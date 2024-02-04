<?php

if (isset($_GET['movieId'])) {
    $movieIdToDelete = $_GET['movieId'];
    deleteMovie($movieIdToDelete);
}