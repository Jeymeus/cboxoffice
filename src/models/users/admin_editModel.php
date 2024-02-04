<?php

/**
 * Check if the email is already in the database
 */

function checkAlreadyExistEmail(): mixed
{
    global $db;

    if (!empty($_GET['id'])) {
        $email = getUser()->email;

        if ($email === $_POST['email']) {
            return false;
        }
    }
    // $data['email'] = $_POST['email'];
    $sql = 'SELECT email FROM users WHERE email = :email';
    $query = $db->prepare($sql);
    $query->bindParam(':email', $_POST['email']);
    $query->execute();

    return $query->fetch();
}

/**
 * Add a user in the database
 */
function addUser()
{
    global $db;
    $data = [
        'email' => $_POST['email'],
        'pwd' => password_hash($_POST['pwd'], PASSWORD_DEFAULT),
        'role_id' => 1
    ];

    try {
        $sql = 'INSERT INTO users (id, email, pwd, role_id) VALUES (UUID(), :email, :pwd, :role_id)';
        $query = $db->prepare($sql);
        $query->execute($data);
        alert('Un utilisateur a bien été ajouté.', 'success');
    } catch (PDOException $e) {
        if ($_ENV['DEBUG'] == 'true') {
            dump($e->getMessage());
            die;
        } else {
            alert('Une erreur est survenue. Merci de réessayer plus tard', 'danger');
        }
    }
}

function checkPasswordMatch($pwd, $pwdConfirm)
{
    $result = array('valid' => true, 'message' => '');

    if ($pwd != $pwdConfirm) {
        $result['valid'] = false;
        $result['message'] = 'Les mots de passe ne correspondent pas.';
    }

    return $result;
}



/**
 * Function to update user information in the database.
 *
 * @param int $userId The ID of the user to update.
 * @param string $email The new email of the user.
 * @param string $password The new password of the user.
 * @return bool Returns true if the update is successful, otherwise false.
 */
function updateUser()
{
    global $db;

    $data = [
        'email' => $_POST['email'],
        'pwd' => password_hash($_POST['pwd'], PASSWORD_DEFAULT),
        'id' => $_GET['id']
    ];

    try {
        $sql = 'UPDATE users SET email = :email, pwd = :pwd, modified = NOW() WHERE id = :id'; // modified = NOW () est utilisé si on souhaite que la colonne update soit actualisé au moment de l'update et que nous ne l'avons pas prédéfinis dans la table.  //
        $query = $db->prepare($sql);
        $query->execute($data);
        alert('Un utilisateur a bien été modifié.', 'success');
    } catch (PDOException $e) {
        if ($_ENV['DEBUG'] == 'true') {
            dump($e->getMessage());
            die;
        } else {
            alert('Une erreur est survenue. Merci de réessayer plus tard', 'danger');
        }
    }
}
