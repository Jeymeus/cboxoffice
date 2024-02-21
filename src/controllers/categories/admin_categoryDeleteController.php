<?php

// Check if the category ID is present in the URL
if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];

    deleteCategory($categoryId);
}
?>
