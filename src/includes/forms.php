<?php

/**
 * Check if a field is empty
 * 
 * @param string $field
 * @param string $message
 * @return array
 */
function checkEmptyFields($field, $message = 'Please fill in this information.')
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

/**
 * Get the error message
 */
function getMessage()
{
}

/**
 * Get movie details by ID
 * 
 * @param int $movieId
 * @return array
 */
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

/**
 * Get user details
 * 
 * @return array
 */
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
            alert('An error occurred. Please try again later.', 'danger');
        }
    }
}

/**
 * Get the value of a form field
 * 
 * @param string $field
 * @return string
 */
function getValue(string $field): string
{
    if (isset($_POST[$field])) {
        return $_POST[$field];
    }
    return '';
}
