<?php




use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

$movieName = '';
$notePress = '';
$date = '';
$duration = '';
$synopsis = '';
$poster = '';
$trailer = '';
$formTitle = 'Ajouter un Film';
$submitButtonLabel = 'Ajouter Film';

if (isset($_GET['id'])) {
    $movieId = $_GET['id'];

    // Assurez-vous que $movieId est un entier
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
} else  {

    $movieName = getValue('movie_name');
    $notePress = getValue('note_press');
    $date = getValue('date');
    $duration = getValue('duration');
    $synopsis = getValue('synopsis');
    $poster = getValue('poster');
    $trailer = getValue('trailer');
}

function getMovies()
{
    global $db;

    $sql = 'SELECT title, date, duration, synopsis, poster, trailer, note_press FROM movies';
    $query = $db->prepare($sql);
    $query->execute();

    return $query->fetchAll();
}

function checkAlreadyExistTitle()
{
    global $db;
    global $movieId;

    // Requête SQL pour vérifier si le titre existe déjà dans la base de données
    $sql = 'SELECT title FROM movies WHERE title = :title';
    $query = $db->prepare($sql);
    $query->bindParam(':title', $_POST['movie_name']);
    $query->execute();
    $existingTitle = $query->fetch();

    // Si le titre existe déjà et ne correspond pas à celui de l'ID donné
    if (!empty($existingTitle)) {
        if ($movieId) {
            $sql = 'SELECT title FROM movies WHERE id = :id';
            $query = $db->prepare($sql);
            $query->bindParam(':id', $movieId);
            $query->execute();
            $titleById = $query->fetch();
            if ($titleById && $titleById->title === $_POST['movie_name']) {
                return false; // Le titre correspond à celui de l'ID donné
            } else {
                return true; // Le titre existe mais ne correspond pas à celui de l'ID donné
            }
        }
        return true; // Le titre existe mais aucun ID n'est donné
    }
    return false; // Le titre n'existe pas
}








function checkAlreadyExistFile($targetToSave): mixed
{
    global $db;
    $sql = 'SELECT poster FROM movies WHERE poster = :poster';
    $query = $db->prepare($sql);
    $query->bindParam(':poster', $targetToSave);
    $query->execute();

    $posterExist = $query->fetch(PDO::FETCH_ASSOC);

    return $posterExist ? $posterExist : [];
}


function insertMovie($movieSlug, $targetToSave)
{

    global $db;
    global $router;
    $data = [
        'movie_name' => $_POST['movie_name'],
        'slug' => $movieSlug,
        'date' => $_POST['date'],
        'duration' => $_POST['duration'],
        'synopsis' => $_POST['synopsis'],
        'poster' => $targetToSave,
        'note_press' => $_POST['note_press'],
    ];

    try {

        $sql = "INSERT INTO movies (title, slug, date, duration, synopsis, poster, note_press) VALUES (:movie_name, :slug, :date, :duration, :synopsis, :poster, :note_press)";

        $query = $db->prepare($sql);
        $query->execute($data);

        header('Location: ' . $router->generate('library'));
        exit();
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

function updateMovie($movieId, $targetToSave)
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
    ];

    try {
        $sql = 'UPDATE movies SET title = :movie_name, date = :date, duration = :duration, synopsis = :synopsis, poster = :poster, note_press = :note_press WHERE id = :movieId';

        $data['movieId'] = $movieId;

        $query = $db->prepare($sql);
        $query->execute($data);

        header('Location: ' . $router->generate('library'));
        exit();
    } catch (PDOException $e) {
        echo 'Erreur de mise à jour : ' . $e->getMessage();
    }
}


function uploadMovieLessPoster($movieId)
{
    global $db;
    global $router;

    $data = [
        'movie_name' => $_POST['movie_name'],
        'date' => $_POST['date'],
        'duration' => $_POST['duration'],
        'synopsis' => $_POST['synopsis'],
        'note_press' => $_POST['note_press'],
    ];

    try {
        $sql = 'UPDATE movies SET title = :movie_name, date = :date, duration = :duration, synopsis = :synopsis, note_press = :note_press WHERE id = :movieId';

        $data['movieId'] = $movieId;

        $query = $db->prepare($sql);
        $query->execute($data);

        header('Location: ' . $router->generate('library'));
        exit();
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

function formatBytes($size, $precision = 2)
{
    $base     = log($size, 1024);
    $suffixes = ['', 'Ko', 'Mo', 'Go', 'To'];

    return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
}

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

function removeAccent($string)
{
    $string = str_replace(
        ['à', 'á', 'â', 'ã', 'ä', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý'],
        ['a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y'],
        $string
    );
    return $string;
}

function resizePoster($manager, $targetToSave)
{

    $manager = new ImageManager(new Driver());
    $image = $manager->read($targetToSave);
    $image->resize(height: 500);
    $image->resize(width: 350);
    $image->save($targetToSave);
}

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
function updateCategory()
{
    global $db;
    global $movieId;

    // Récupérez les catégories déjà associées au film depuis la base de données
    $existingCategories = getCategoryByMovie($movieId);

    // Initialisez un tableau pour stocker les ID des catégories déjà associées
    $existingCategoryIds = [];

    // Stockez les ID des catégories déjà associées au film dans un tableau
    foreach ($existingCategories as $existingCategory) {
        $existingCategoryIds[] = $existingCategory->id;
    }

    // Récupérez toutes les catégories disponibles
    $allCategories = getCategory();

    // Initialisez un tableau pour stocker les catégories sélectionnées dans le formulaire
    $selectedCategories = [];

    // Parcourez toutes les catégories disponibles et vérifiez si elles ont été cochées dans le formulaire
    foreach ($allCategories as $category) {
        $categoryId = $category->id;
        if (in_array($categoryId, $_POST['categories'])) {
            $selectedCategories[] = $categoryId;
        }
    }

    // Comparez les catégories déjà associées avec les nouvelles catégories sélectionnées
    $categoriesToDelete = array_diff($existingCategoryIds, $selectedCategories);
    $categoriesToAdd = array_diff($selectedCategories, $existingCategoryIds);

    // Supprimez les catégories désélectionnées de la table movie_category
    foreach ($categoriesToDelete as $categoryId) {
        $sql = 'DELETE FROM movie_category WHERE movie_id = :movie_id AND category_id = :category_id';
        $query = $db->prepare($sql);
        $query->bindParam(':movie_id', $movieId, PDO::PARAM_INT);
        $query->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $query->execute();
    }

    // Ajoutez les nouvelles catégories sélectionnées à la table movie_category
    foreach ($categoriesToAdd as $categoryId) {
        $sql = 'INSERT INTO movie_category (movie_id, category_id) VALUES (:movie_id, :category_id)';
        $query = $db->prepare($sql);
        $query->bindParam(':movie_id', $movieId, PDO::PARAM_INT);
        $query->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $query->execute();
    }
}

// Appeler la fonction updateCategory() si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($movieId)) {
    updateCategory();
}
