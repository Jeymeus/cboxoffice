<?php

$categoryID = $_GET['id'];

function deleteCategory($categoryId)
{
    global $db;
    global $router;

    try {
        $deleteCategory = "DELETE FROM category WHERE id = :id";
        $statement = $db->prepare($deleteCategory);
        $statement->bindParam(':id', $categoryId, PDO::PARAM_INT);
        $statement->execute();

        alert('La catégorie a bien été supprimée', 'success');
        header('Location: ' . $router->generate('categories')); // Rediriger vers la page des catégories après suppression
        exit();
    } catch (PDOException $e) {
        alert('Erreur lors de la suppression de la catégorie : ' . $e->getMessage());
        header('Location: ' . $router->generate('categories'));
    }
}
