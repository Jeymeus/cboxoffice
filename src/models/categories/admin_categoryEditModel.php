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
function insertCategory($category)
{
    global $db;
    global $router;
    $sql = 'INSERT INTO category (name) VALUES (?)';
    $query = $db->prepare($sql);
    $query->execute([$category]);

    header('Location: ' . $router->generate('moviesEdit'));
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