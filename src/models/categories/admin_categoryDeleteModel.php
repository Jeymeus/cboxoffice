<?php
/**
 * Deletes a category from the database based on the provided category ID.
 *
 * @param int $categoryId The ID of the category to be deleted.
 * @return void
 */
function deleteCategory($categoryId)
{
    global $db; 
    global $router; 

    try {
        $deleteCategory = "DELETE FROM category WHERE id = :id";
        $statement = $db->prepare($deleteCategory);
        $statement->bindParam(':id', $categoryId, PDO::PARAM_INT);
        $statement->execute();

        alert('The category has been successfully deleted.', 'success');
        header('Location: ' . $router->generate('categories'));
        exit(); 
    } catch (PDOException $e) {
        alert('Error deleting category: ' . $e->getMessage());
        header('Location: ' . $router->generate('categories'));
    }
}
?>
