<?php

// Vérification si l'ID de la catégorie est présent dans l'URL
if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];
    deleteCategory($categoryId);
}
