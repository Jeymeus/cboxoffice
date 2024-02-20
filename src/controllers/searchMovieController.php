<?php


// Récupérer le terme de recherche depuis le formulaire
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Vérifier si $search n'est pas vide
if (!empty($search)) {
    $searchMovies = userSearchMovies($search);

    $data['searchMovies']= $searchMovies;

} else {
    // Si le terme de recherche est vide, redirigez vers la page d'accueil
    header("Location: index.php");
    exit(); // Assurez-vous que le script s'arrête après la redirection
}







