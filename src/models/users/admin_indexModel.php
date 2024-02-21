<?php

/**
 * Retrieves all users from the database.
 *
 * @return object Returns an object containing the IDs and emails of all users.
 */

function getUsers()
{
    global $db;

    $sql = 'SELECT id, email FROM users';
    $query = $db->prepare($sql);
    $query->execute();

    return $query->fetchAll();
}
