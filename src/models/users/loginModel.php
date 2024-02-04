<?php

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
    





function saveLastLogin(string $userId)
{
    global $db;
    $sql = 'UPDATE users SET lastLogin = NOW() WHERE id= :id';
    $query = $db->prepare($sql);
    $query->execute(['id' => $userId]);

    // try catch 

}

