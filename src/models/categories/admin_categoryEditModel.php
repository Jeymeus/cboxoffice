<?php

// $movieName = $_SESSION['movieName'];
// $notePress = $_SESSION['notePress'];
// $date = $_SESSION['date'];
// $duration = $_SESSION['duration'];
// $synopsis = $_SESSION['synopsis'];
// $trailer = $_SESSION['trailer'];

// dump($_SESSION);

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
    $sql = 'INSERT INTO category (name) VALUES (?)';
    $query = $db->prepare($sql);
    $query->execute([$category]);
}
