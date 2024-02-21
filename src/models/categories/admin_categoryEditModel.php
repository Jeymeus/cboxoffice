<?php

/**
 * movieName = $_SESSION['movieName'] ?? '';: 
 * If $_SESSION['movieName'] is set and not null, assign its value to $movieName, 
 * otherwise assign an empty string ''.
 */

$movieName = $_SESSION['movieName'] ?? '';
$notePress = $_SESSION['notePress'] ?? '';
$date = $_SESSION['date'] ?? '';
$duration = $_SESSION['duration'] ?? '';
$synopsis = $_SESSION['synopsis'] ?? '';
$trailer = $_SESSION['trailer'] ?? '';

$category1 = getValue('category1');
$category2 = getValue('category2');
$category3 = getValue('category3');


/**
 * Retrieves all categories from the database.
 *
 * @return array An array containing all categories.
 */
function getCategory()
{
    global $db;
    $sql = 'SELECT * FROM category ORDER BY name'; 
    $query = $db->prepare($sql);
    $query->execute();
    $allCategory = $query->fetchAll();

    return $allCategory;
}

$allCategory = getCategory();

/**
 * Inserts a new category into the database.
 *
 * @param string $category The name of the category to insert.
 * @return void
 */
function insertCatry($category)
{
    global $db;
    global $router;
    $sql = 'INSERT INTO category (name) VALUES (?)';
    $query = $db->prepare($sql);
    $query->execute([$category]);

    header('Location: ' . $router->generate('moviesEdit'));
}

/**
 * Inserts a new category into the database and handles redirection based on movie details.
 *
 * @param string $category The name of the category to insert.
 * @return void
 */
function insertCategory($category)
{
    global $db;
    global $router;

    // Check if any session variables associated with movie details are empty
    $movieName = $_SESSION['movieName'] ?? '';
    $notePress = $_SESSION['notePress'] ?? '';
    $date = $_SESSION['date'] ?? '';
    $duration = $_SESSION['duration'] ?? '';
    $synopsis = $_SESSION['synopsis'] ?? '';
    $trailer = $_SESSION['trailer'] ?? '';

    if (!empty($movieName) || !empty($notePress) || !empty($date) || !empty($duration) || !empty($synopsis) || !empty($trailer)) {
        $sql = 'INSERT INTO category (name) VALUES (?)';
        $query = $db->prepare($sql);
        $query->execute([$category]);
        header('Location: ' . $router->generate('moviesEdit'));
    } else {
        $sql = 'INSERT INTO category (name) VALUES (?)';
        $query = $db->prepare($sql);
        $query->execute([$category]);
        header('Location: ' . $router->generate('categories'));
    }
}

/**
 * Checks if a category already exists in the database.
 *
 * @param string $categoryName The name of the category to check.
 * @return bool True if the category exists, false otherwise.
 */
function categoryExists($categoryName)
{
    global $db;
    //SELECT COUNT(*) because use checkboxs and its possible to have few categories
    $sql = 'SELECT COUNT(*) as count FROM category WHERE name = :categoryName';
    $query = $db->prepare($sql);
    $query->bindParam(':categoryName', $categoryName, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result['count'] > 0;
}
?>