<?php

/**
 * 
 *Check if a field is empty
 * @param string $field
 * @param string $message
 * @return array
 */
function checkEmptyFields($field, $message = 'Veuillez renseigner cette information.')
{
    $result    = ['class' => '', 'message' => ''];

    if (isset($_POST[$field]) && empty($_POST[$field])) {
        $result = [
            'class' => 'is-invalid',
            'message' => '<span class="invalid-feedback">' . $message . '</span>'
        ];
    }
    
    return $result;
}

function getMessage()
{
}

function getMovieById($movieId)
{
    global $db;

    $sql = "SELECT * FROM movies WHERE id = :id";
    $query = $db->prepare($sql);
    $query->bindParam(':id', $movieId, PDO::PARAM_INT);
    $query->execute();
    $movieDetails = $query->fetch(PDO::FETCH_ASSOC);

    return $movieDetails;
}

function getUser()
{
    global $db;
    try {
        $sql = "SELECT email FROM users WHERE id = :id";
        $query = $db->prepare($sql);
        $query->execute(['id' => $_GET['id']]);
        
        return $query->fetch();
    } catch (PDOException $e) {
        if ($_ENV['DEBUG'] == 'true') {
            dump($e->getMessage());
            die;
        } else {
            alert('Une erreur est survenue. Merci de réessayer plus tard', 'danger');
        }
    }
}

function getValue(string $field): string
{
    if (isset($_POST[$field])) {
        return $_POST[$field];
    }
    return '';
}









