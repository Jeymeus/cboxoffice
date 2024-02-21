<?php

/**
 * Checks user access by verifying the email and password in the database.
 *
 * @return int|bool Returns the user ID if authentication is successful, otherwise returns false.
 */
function checkUserAccess()
{
    global $db;

        $sql = 'SELECT id, pwd FROM users WHERE email = :email';
        $query = $db->prepare($sql);
        $query->execute(['email' => $_POST['email']]);

        $user = $query->fetch();
        
            if ($user && password_verify($_POST['pwd'], $user->pwd)) {
                return $user->id;
            } else {
                alert('Identifiants incorrects', 'danger');
                return false;
            }
        
        }
    





/**
 * Saves the last login time for a user in the database.
 * 
 * @param string $userId The ID of the user whose last login time is to be updated.
 * @return void
 */
function saveLastLogin(string $userId)
{
    global $db;
    try {
        $sql = 'UPDATE users SET lastLogin = NOW() WHERE id= :id';
        $query = $db->prepare($sql);
        $query->execute(['id' => $userId]);
    } catch (PDOException $e) {
        if ($_ENV['DEBUG'] == 'true') {
            dump($e->getMessage());
            die;
        } else {
            alert('Une erreur est survenue.', 'danger');
        }
    }
} 


