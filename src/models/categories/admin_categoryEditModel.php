<?php

$movieName = $_SESSION['movieName'] ?? '';
$notePress = $_SESSION['notePress'] ?? '';
$date = $_SESSION['date'] ?? '';
$duration = $_SESSION['duration'] ?? '';
$synopsis = $_SESSION['synopsis'] ?? '';
$trailer = $_SESSION['trailer'] ?? '';

$category1 = getValue('category1');
$category2 = getValue('category2');
$category3 = getValue('category3');


function getCategory()
{
    global $db;
    $sql = 'SELECT * FROM category ORDER bY name';
    $query = $db->prepare($sql);
    $query->execute();
    $allCategory = $query->fetchAll();

    return $allCategory;
}

$allCategory = getCategory();

// Fonction pour insérer une catégorie dans la base de données
function insertCatry($category)
{
    global $db;
    global $router;
    $sql = 'INSERT INTO category (name) VALUES (?)';
    $query = $db->prepare($sql);
    $query->execute([$category]);

    header('Location: ' . $router->generate('moviesEdit'));
}

function insertCategory($category)
{
    global $db;
    global $router;

    // Vérifier si l'une des variables de session associées aux détails du film est vide
    $movieName = $_SESSION['movieName'] ?? '';
    $notePress = $_SESSION['notePress'] ?? '';
    $date = $_SESSION['date'] ?? '';
    $duration = $_SESSION['duration'] ?? '';
    $synopsis = $_SESSION['synopsis'] ?? '';
    $trailer = $_SESSION['trailer'] ?? '';

    if (!empty($movieName) || !empty($notePress) || !empty($date) || !empty($duration) || !empty($synopsis) || !empty($trailer)) {
        // Redirection vers moviesEdit
        // Insertion de la catégorie dans la base de données
        $sql = 'INSERT INTO category (name) VALUES (?)';
        $query = $db->prepare($sql);
        $query->execute([$category]);
        header('Location: ' . $router->generate('moviesEdit'));
        
    } else {
        // Insertion de la catégorie dans la base de données
        $sql = 'INSERT INTO category (name) VALUES (?)';
        $query = $db->prepare($sql);
        $query->execute([$category]);

        // Redirection vers la page des catégories
        header('Location: ' . $router->generate('categories'));
        }
}



function categoryExists($categoryName)
{
    global $db;
    $sql = 'SELECT COUNT(*) as count FROM category WHERE name = :categoryName';
    $query = $db->prepare($sql);
    $query->bindParam(':categoryName', $categoryName, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result['count'] > 0;
}