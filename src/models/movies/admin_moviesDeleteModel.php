<?php

$sql = 'SELECT * FROM movies';
$query = $db->query($sql);
$movies = $query->fetchAll(PDO::FETCH_ASSOC);



$movieName = '';
$notePress = '';
$date = '';
$duration = '';
$synopsis = '';

if (isset($_GET['id'])) {
    $movieId = $_GET['id'];

    $movieDetails = getMovieById($movieId);

    if ($movieDetails) {

        $movieName = $movieDetails['title'];
        $notePress = $movieDetails['note_press'];
        $date = $movieDetails['date'];
        $duration = $movieDetails['duration'];
        $synopsis = $movieDetails['synopsis'];
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $movieName = getValue('movie_name');
    $notePress = getValue('note_press');
    $date = getValue('date');
    $duration = getValue('duration');
    $synopsis = getValue('synopsis');
}

function deleteMovie($movieId)
{
    global $db;
    global $router;

    try {
        // Supprimer les entrées associées dans la table movie_category
        $deleteMovieCategory = "DELETE FROM movie_category WHERE movie_id = :movieId";
        $statementMovieCategory = $db->prepare($deleteMovieCategory);
        $statementMovieCategory->bindParam(':movieId', $movieId, PDO::PARAM_INT);
        $statementMovieCategory->execute();

        // Supprimer le film de la table movies
        $deleteMovie = "DELETE FROM movies WHERE id = :movieId";
        $statement = $db->prepare($deleteMovie);
        $statement->bindParam(':movieId', $movieId, PDO::PARAM_INT);
        $statement->execute();

        alert('Le film a bien été supprimé', 'success');
        header('Location: ' . $router->generate('library'));
        exit();
    } catch (PDOException $e) {
        alert('Erreur lors de la suppression du film : ' . $e->getMessage());
        header('Location: ' . $router->generate('library'));
    }
}