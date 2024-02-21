<?php 
/**
 * Delete a user from the database
 */
function deleteUser ()
{
    try {
        global $db;
        $sql = 'DELETE FROM users WHERE id = :id';
        $query = $db->prepare($sql);
        $query->execute(['id' => $_GET['id']]);
    } catch (PDOException $e) {
        if ($_ENV['DEBUG'] == 'true') {
            dump($e->getMessage());
            die;
        } else {
            alert('Une erreur est survenue. Merci de réessayer plus tard', 'danger');
        }
    }
}

/**
 * Retrieves the user ID if it already exists in the database.
 *
 * @return object|null Returns an object containing the ID of the user if it exists, or null otherwise.
 */
function getAlreadyExistId()
{
    try {
        global $db;
        $sql = 'SELECT id FROM users WHERE id = :id';
        $query = $db->prepare($sql);
        $query->execute(['id' => $_GET['id']]);

        return $query->fetch();
    } catch (PDOException $e) {
        if ($_ENV['DEBUG'] == 'true') {
            dump($e->getMessage());
            die;
        } else {
            alert('Une erreur est survenue. Merci de réessayer plus tard.', 'danger');
        }
    }
}

/**
 * Counts the total number of users in the database.
 *
 * @return int Returns the total number of users.
 */
function countUsers() 
{
    global $db;
    $sql = 'SELECT COUNT(*) FROM users';
    $query = $db->prepare($sql);
    $query->execute();

    return $query->fetchColumn();
}