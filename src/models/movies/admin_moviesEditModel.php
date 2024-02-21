<?php


use Intervention\Image\Drivers\Gd\Driver;
use Symfony\Component\VarDumper\Server\DumpServer;


$formTitle = 'Ajouter un Film';
$submitButtonLabel = 'Ajouter Film';


if (isset($_GET['id'])) {
    $movieId = $_GET['id'];

    $movieId = intval($movieId);
    $movieDetails = getMovieById($movieId);

    if ($movieDetails) {

        $movieName = $movieDetails['title'];
        $notePress = $movieDetails['note_press'];
        $date = $movieDetails['date'];
        $duration = $movieDetails['duration'];
        $synopsis = $movieDetails['synopsis'];
        $poster = $movieDetails['poster'];
        $trailer = $movieDetails['trailer'];

        $formTitle = 'Modifier un Film';
        $submitButtonLabel = 'Modifier';
    }
} else {


    $movieName = $_SESSION['movieName'] ?? getValue('movie_name');
    $notePress = $_SESSION['notePress'] ?? getValue('note_press');
    $date = $_SESSION['date'] ?? getValue('date');
    $duration = $_SESSION['duration'] ?? getValue('duration');
    $synopsis = $_SESSION['synopsis'] ?? getValue('synopsis');
    $trailer = $_SESSION['trailer'] ?? getValue('trailer');

    unset($_SESSION['movieName']);
    unset($_SESSION['notePress']);
    unset($_SESSION['date']);
    unset($_SESSION['duration']);
    unset($_SESSION['synopsis']);
    unset($_SESSION['trailer']);
}

/**
 * Fetches the list of all movies from the database.
 * 
 * @return object
 */
function getMovies()
{
    global $db;

    $sql = 'SELECT title, date, duration, synopsis, poster, trailer, note_press FROM movies';
    $query = $db->prepare($sql);
    $query->execute();

    return $query->fetchAll();
}

/**
 * Checks if a movie title already exists in the database.
 * 
 * @return bool True if the title already exists and doesn't match the given ID, false otherwise
 */
function checkAlreadyExistTitle()
{
    global $db;
    global $movieId;

    $sql = 'SELECT title FROM movies WHERE title = :title';
    $query = $db->prepare($sql);
    $query->bindParam(':title', $_POST['movie_name']);
    $query->execute();
    $existingTitle = $query->fetch();

    // If the title already exists and doesn't match the given ID
    if (!empty($existingTitle)) {
        if ($movieId) { // If a movie ID is provided
            // Check if the existing title belongs to the given ID
            $sql = 'SELECT title FROM movies WHERE id = :id';
            $query = $db->prepare($sql);
            $query->bindParam(':id', $movieId);
            $query->execute();
            $titleById = $query->fetch();

            if ($titleById && $titleById->title === $_POST['movie_name']) {
                return false; // The title matches the given ID
            } else {
                return true; // The title exists but doesn't match the given ID
            }
        }
        return true; // The title exists but no ID is given
    }
    return false; // The title doesn't exist
}

/**
 * Checks if a poster already exists in the database.
 * 
 * @param string $targetToSave The poster name to check
 * @return mixed The existing poster if found, an empty array otherwise
 */
function checkAlreadyExistFile(string $targetToSave): mixed
{
    global $db;
    $sql = 'SELECT poster FROM movies WHERE poster = :poster';
    $query = $db->prepare($sql);
    $query->bindParam(':poster', $targetToSave);
    $query->execute();

    $posterExist = $query->fetch(PDO::FETCH_ASSOC);

    return $posterExist ? $posterExist : [];
    //$posterExist ? $posterExist : [], the first part, $posterExist
    //If this condition evaluates to true, then the value of $posterExist is returned otherwise []
}

/**
 * Inserts a new movie record into the database.
 * 
 * @param string $movieSlug The slug of the movie
 * @param string $targetToSave The name of the poster file
 */
function insertMovie($movieSlug, $targetToSave)
{
    global $db;
    $data = [
        'movie_name' => $_POST['movie_name'],
        'slug' => $movieSlug,
        'date' => $_POST['date'],
        'duration' => $_POST['duration'],
        'synopsis' => $_POST['synopsis'],
        'poster' => $targetToSave,
        'note_press' => $_POST['note_press'],
        'trailer' => $_POST['trailer'], // Ajout du champ trailer
    ];

    try {
        $sql = "INSERT INTO movies (title, slug, date, duration, synopsis, poster, note_press, trailer) VALUES (:movie_name, :slug, :date, :duration, :synopsis, :poster, :note_press, :trailer)";
        $query = $db->prepare($sql);
        $query->execute($data);

        $lastInsertedId = $db->lastInsertId();

        // header('Location: ' . $router->generate('library'));
        // exit();

        return $lastInsertedId;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

/**
 * Updates an existing movie record in the database.
 * 
 * @param int $movieId The ID of the movie to update
 * @param string $targetToSave The name of the poster file
 */
function updateMovie(int $movieId, string $targetToSave)
{
    global $db;
    global $router;

    $data = [
        'movie_name' => $_POST['movie_name'],
        'date' => $_POST['date'],
        'duration' => $_POST['duration'],
        'synopsis' => $_POST['synopsis'],
        'poster' => $targetToSave,
        'note_press' => $_POST['note_press'],
        'trailer' => $_POST['trailer'], // Ajout du champ trailer
        'movieId' => $movieId,
    ];

    try {
        $sql = 'UPDATE movies SET title = :movie_name, date = :date, duration = :duration, synopsis = :synopsis, poster = :poster, note_press = :note_press, trailer = :trailer WHERE id = :movieId';

        $query = $db->prepare($sql);
        $query->execute($data);
    } catch (PDOException $e) {
        echo 'Erreur de mise à jour : ' . $e->getMessage();
    }
}

/**
 * Updates an existing movie record in the database.
 * 
 * @param int $movieId The ID of the movie to update
 * @param string $targetToSave The name of the poster file
 */
function uploadMovieLessPoster(int $movieId)
{
    global $db;
    global $router;

    $data = [
        'movie_name' => $_POST['movie_name'],
        'date' => $_POST['date'],
        'duration' => $_POST['duration'],
        'synopsis' => $_POST['synopsis'],
        'note_press' => $_POST['note_press'],
        'trailer' => $_POST['trailer'],
        'movieId' => $movieId,
    ];

    try {
        $sql = 'UPDATE movies SET title = :movie_name, date = :date, duration = :duration, synopsis = :synopsis, note_press = :note_press, trailer = :trailer WHERE id = :movieId';

        $query = $db->prepare($sql);
        $query->execute($data);

        // header('Location: ' . $router->generate('library'));
        // exit();
    } catch (PDOException $e) {
        echo 'Erreur de mise à jour : ' . $e->getMessage();
    }
}

/**	
 * Upload file
 * 
 * @param string $path to save file
 * @param string $field name of input type file
 */
function uploadFile(string $path, string $field, array $exts = ['jpg', 'png', 'jpeg'], int $maxSize = 2097152)
{
    $messageUploadFile = '';

    // Check exit directory if not create
    if (!is_dir($path)) {
        if (!mkdir($path, 0755, true)) {
            $messageUploadFile = 'Impossible d\'importer votre fichier.';
        }
    }

    // Check not empty input file
    if (empty($_FILES[$field]['name'])) :
        $messageUploadFile = 'Merci d\'uploader un fichier';
    endif;

    // Check exts
    $currentExt = pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION);
    $currentExt = strtolower($currentExt);
    if (!in_array($currentExt, $exts)) :
        $exts = implode(', ', $exts);
        $messageUploadFile = 'Merci de charger un fichier avec l\'une de ces extensions : ' . $exts . '.';
    endif;

    // Check no error into current file
    if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) :
        $messageUploadFile = 'Merci de sélectionner un autre fichier.';
    endif;

    // Check max size current file
    if ($_FILES[$field]['size'] > $maxSize) :
        $messageUploadFile = 'Merci de charger un fichier ne dépassant pas cette taille : ' . formatBytes($maxSize);
    endif;

    $filename = pathinfo($_FILES[$field]['name'], PATHINFO_FILENAME);
    $filename = renameFile($filename);
    $targetToSave = $path . '/' . $filename . '.' . $currentExt;

    return ['messagePoster' => $messageUploadFile, 'path' => $targetToSave];
}

/**
 * Formats a file size in bytes to a human-readable format.
 * 
 * @param int $size The file size in bytes
 * @param int $precision The number of decimal places to round to (default is 2)
 * @return string The formatted file size with appropriate suffix (e.g., KB, MB)
 */
function formatBytes(int $size, int $precision = 2)
{
    $base     = log($size, 1024);
    $suffixes = ['', 'Ko', 'Mo', 'Go', 'To'];

    return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
}

/**
 * Renames a file name to make it safe and standardized.
 * 
 * @param string $name The original file name
 * @return string The sanitized and standardized file name
 */
function renameFile(string $name)
{
    $name = trim($name);
    $name = strip_tags($name);
    $name = removeAccent($name);
    $name = preg_replace('/[\s-]+/', ' ', $name);  // Clean up multiple dashes and whitespaces
    $name = preg_replace('/[\s_]/', '-', $name); // Convert whitespaces and underscore to dash
    $name = preg_replace('/[^A-Za-z0-9\-]/', '', $name);
    $name = strtolower($name);
    $name = trim($name, '-');

    return $name;
}

/**
 * Removes accents from characters in a string.
 * 
 * @param string $string The input string with accents
 * @return string The string with accents removed
 */
function removeAccent($string)
{
    $string = str_replace(
        ['à', 'á', 'â', 'ã', 'ä', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý'],
        ['a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y'],
        $string
    );
    return $string;
}

/**
 * Resize the poster image to specific dimensions.
 * 
 * @param ImageManager $manager The ImageManager instance
 * @param string $targetToSave The path to the image file to be resized
 */
function resizePoster($manager, $targetToSave)
{

    $image = $manager->read($targetToSave);
    $image->resize(height: 500);
    $image->resize(width: 350);
    $image->save($targetToSave);
}

/**
 * Retrieve all categories from the database.
 * 
 * @return array An array containing all categories
 */
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

/**
 * Retrieve categories associated with a specific movie from the database.
 * 
 * @return object
 */
function getCategoryByMovie()
{

    global $db;
    global $movieId;

    $sql = 'SELECT c.*
            FROM category c
            JOIN movie_category mc ON c.id = mc.category_id
            WHERE mc.movie_id = :movie_id';

    $query = $db->prepare($sql);
    $query->bindParam(':movie_id', $movieId, PDO::PARAM_INT);
    $query->execute();

    $categoryByMovies = $query->fetchAll();

    return $categoryByMovies;
}

$categoryByMovies = getCategoryByMovie();


// Définition de la fonction pour mettre à jour les catégories associées à un film
function updateCategory($lastInsertedId)
{
    global $db;
    global $movieId;

    $existingCategories = getCategoryByMovie($movieId);

    // If no existing categories found, insert the selected categories
    if (empty(getCategoryByMovie($lastInsertedId))) {
        $allCategories = getCategory();

        foreach ($allCategories as $category) {
            $categoryId = $category->id;
            if (in_array($categoryId, $_POST['categories'])) {
                $sql = 'INSERT INTO movie_category (movie_id, category_id) VALUES (:movie_id, :category_id)';
                $query = $db->prepare($sql);
                $query->bindParam(':movie_id', $lastInsertedId, PDO::PARAM_INT);
                $query->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
                $query->execute();
            }
        }
    } else {
        // Existing categories found, proceed with update logic
        $existingCategoryIds = [];
        foreach ($existingCategories as $existingCategory) {
            $existingCategoryIds[] = $existingCategory->id;
        }

        $allCategories = getCategory();

        $selectedCategories = [];

        foreach ($allCategories as $category) {
            $categoryId = $category->id;
            if (in_array($categoryId, $_POST['categories'])) {
                $selectedCategories[] = $categoryId;
            }
        }

        // Compare the existing associated categories with the newly selected categories
        $categoriesToDelete = array_diff($existingCategoryIds, $selectedCategories);
        $categoriesToAdd = array_diff($selectedCategories, $existingCategoryIds);

        // Delete deselected categories from the movie_category table
        foreach ($categoriesToDelete as $categoryId) {
            $sql = 'DELETE FROM movie_category WHERE movie_id = :movie_id AND category_id = :category_id';
            $query = $db->prepare($sql);
            $query->bindParam(':movie_id', $movieId, PDO::PARAM_INT);
            $query->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
            $query->execute();
        }

        // Add newly selected categories to the movie_category table
        foreach ($categoriesToAdd as $categoryId) {
            $sql = 'INSERT INTO movie_category (movie_id, category_id) VALUES (:movie_id, :category_id)';
            $query = $db->prepare($sql);
            $query->bindParam(':movie_id', $movieId, PDO::PARAM_INT);
            $query->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
            $query->execute();
        }
    }
}
