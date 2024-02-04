<?php

$sql = 'SELECT * FROM movies';
$query = $db->query($sql);
$movies = $query->fetchAll(PDO::FETCH_ASSOC);



$movieName = '';
$notePress = '';
$date = '';
$duration = '';
$synopsis = '';
$formTitle = 'Ajouter un Film';
$submitButtonLabel = 'Ajouter Film';

if (isset($_GET['id'])) {
    $movieId = $_GET['id'];
    
    $movieDetails = getMovieById($movieId);
    
    if ($movieDetails) {
        
        $movieName = $movieDetails['title'];
        $notePress = $movieDetails['note_press'];
        $date = $movieDetails['date'];
        $duration = $movieDetails['duration'];
        $synopsis = $movieDetails['synopsis'];
        
        $formTitle = 'Modifier un Film';
        $submitButtonLabel = 'Modifier';
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $movieName = getValue('movie_name');
    $notePress = getValue('note_press');
    $date = getValue('date');
    $duration = getValue('duration');
    $synopsis = getValue('synopsis');
}
    
    
?>