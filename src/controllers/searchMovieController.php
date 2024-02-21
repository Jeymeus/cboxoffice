<?php

// Retrieve the search term from the form
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Check if $search is not empty
if (!empty($search)) {
    $searchMovies = userSearchMovies($search);

    $data['searchMovies'] = $searchMovies;
} else {
    // If the search term is empty, redirect to the homepage
    header("Location: index.php");
    exit(); 
}
?>



