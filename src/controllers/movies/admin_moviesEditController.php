<?php

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

// Check if the form has been submitted and the "Add Category" button has been clicked
if (isset($_POST['new-category'])) {
    $_SESSION['movieName'] = $movieName;
    $_SESSION['notePress'] = $notePress;
    $_SESSION['date'] = $date;
    $_SESSION['duration'] = $duration;
    $_SESSION['synopsis'] = $synopsis;
    $_SESSION['trailer'] = $trailer;
    header('Location: ' . $router->generate('categoryEdit'));
    exit(); 
}

// Initialize variables 
$errorsMessage = [
    'movie_name' => false,
    'date' => false,
    'duration' => false,
    'synopsis' => false,
    'poster' => false,
    'trailer' => false,
    'note_press' => false,
    'categories' => false
];

$errorsClass = [
    'movie_name' => false,
    'date' => false,
    'duration' => false,
    'synopsis' => false,
    'poster' => false,
    'trailer' => false,
    'note_press' => false,
    'categories' => false
];

$globalMessage = [
    'class' => 'd-none',
    'message' => false
];

if (empty($_GET['id']) || empty($poster)) {
    $imgPoster = 'd-none';
}

// Check if the form has been submitted
if (!empty($_POST)) {
    // Determine if the operation is an update
    $isUpdate = isset($_GET['id']) && is_numeric($_GET['id']);

    // Retrieve form data
    $movieName = getValue('movie_name');
    $notePress = getValue('note_press');
    $date = getValue('date');
    $duration = getValue('duration');
    $synopsis = getValue('synopsis');
    $trailer = getValue('trailer');

    // Validate movie title
    if (empty($movieName)) {
        $errorsMessage['movie_name'] = '<span class="invalid-feedback">Le titre du film est obligatoire.</span>';
        $errorsClass['movie_name'] = 'is-invalid';
    } else {
        // If an ID is passed and the title already exists but does not match the ID
        if (!empty($_GET['id'])) {
            $existingTitle = checkAlreadyExistTitle($_GET['id']);
            if ($existingTitle == true) {
                $errorsMessage['movie_name'] = '<span class="invalid-feedback">Le titre du film existe déjà.</span>';
                $errorsClass['movie_name'] = 'is-invalid';
            }
        }
    }

    // Validate movie date
    if (empty($date)) {
        $errorsMessage['date'] = '<span class="invalid-feedback">La date du film est obligatoire.</span>';
        $errorsClass['date'] = 'is-invalid';
    } else {
        $parsedDate = date_parse($date);
        if (!$parsedDate || $parsedDate['error_count'] > 0 || !checkdate($parsedDate['month'], $parsedDate['day'], $parsedDate['year'])) {
            $errorsMessage['date'] = '<span class="invalid-feedback">Veuillez saisir une date valide.</span>';
            $errorsClass['date'] = 'is-invalid';
        }
    }

    // Validate movie duration
    if (empty($duration)) {
        $errorsMessage['duration'] = '<span class="invalid-feedback">La durée du film est obligatoire.</span>';
        $errorsClass['duration'] = 'is-invalid';
    } else {
        $regexDuration = '/^\d{1,3}$/';
        if (!preg_match($regexDuration, $duration)) {
            $errorsMessage['duration'] = '<span class="invalid-feedback">Veuillez saisir une durée en minutes.</span>';
            $errorsClass['duration'] = 'is-invalid';
        }
    }

    // Validate movie synopsis
    if (empty($synopsis)) {
        $errorsMessage['synopsis'] = '<span class="invalid-feedback">Le synopsis du film est obligatoire.</span>';
        $errorsClass['synopsis'] = 'is-invalid';
    }

    // Validate movie press note
    if (isset($notePress) && !empty($notePress)) {
        $regexDuration = '/^(?:10|\d(?:\.\d{1,2})?)$/';
        if (!preg_match($regexDuration, $notePress)) {
            $errorsMessage['note_press'] = '<span class="invalid-feedback">Veuillez saisir une note comprise entre 0 et 10, séparée par un point.</span>';
            $errorsClass['note_press'] = 'is-invalid';
        }
    } else {
        $errorsMessage['note_press'] = '<span class="invalid-feedback">La note est obligatoire.</span>';
        $errorsClass['note_press'] = 'is-invalid';
    }

    // Validate categories
    if (empty($_POST['categories'])) {
        $errorsMessage['categories'] = '<div><p class="text-danger">Merci de sélectionner au moins une catégorie.</p></div>';
        $errorsClass['categories'] = 'bg-danger text-white';
    }

    if (count(array_filter($errorsMessage)) == 0) {
        // Process poster upload if not empty
        if (!empty($_FILES['poster']['name'])) {
            // Initialize variable to poster
            $uploadPath = 'uploads';
            $uploadResult = uploadFile($uploadPath, 'poster');
            $manager = new ImageManager(new Driver());

            if (!empty($uploadResult['messagePoster'])) {
                $errorsMessage['poster'] = '<span class="invalid-feedback">' . $uploadResult['messagePoster'] . '</span>';
                $errorsClass['poster'] = 'is-invalid';
            // check if function uploadFile is true
            } else if (!empty($uploadResult['path'])) {
                $targetToSave = $uploadResult['path'];
                $alreadyExistFiles = checkAlreadyExistFile($targetToSave);
                // check if insert or upload movie 
                if (in_array($targetToSave, $alreadyExistFiles) && !isset($_GET['id'])) {
                    $errorsMessage['poster'] = '<span class="invalid-feedback">Le nom de l\'affiche existe déjà.</span>';
                    $errorsClass['poster'] = 'is-invalid';
                } elseif (in_array($targetToSave, $alreadyExistFiles) && isset($_GET['id'])) {
                    $movie = getMovieById($_GET['id']);
                    if ($movie && $movie['poster'] === $targetToSave) {
                        if (count(array_filter($errorsMessage)) > 0) {
                            alert('Erreur lors de la modification');
                        }
                        alert('Le film a été modifié avec succès', 'success');
                        uploadMovieLessPoster($movieId);
                        updateCategory($lastInsertedId);
                        header('Location: ' . $router->generate('library'));
                        exit();
                    } else {
                        $errorsMessage['poster'] = '<span class="invalid-feedback">Une affiche du même nom existe.</span>';
                        $errorsClass['poster'] = 'is-invalid';
                    }
                } elseif (isset($_GET['id']) && !in_array($targetToSave, $alreadyExistFiles)) {
                    if (!move_uploaded_file($_FILES['poster']['tmp_name'], $targetToSave)) {
                        $errorsMessage['poster'] = '<span class="invalid-feedback">L\'affiche n\'a pas été téléchargé.</span>';
                        $errorsClass['poster'] = 'is-invalid';
                    } elseif (count(array_filter($errorsMessage)) > 0) {
                        alert('Erreur lors de la modification');
                    }
                    alert('Le film a été modifié avec succès', 'success');
                    resizePoster($manager, $targetToSave);
                    updateMovie($movieId, $targetToSave);
                    updateCategory($lastInsertedId);
                    header('Location: ' . $router->generate('library'));
                    exit();
                } elseif (!isset($_GET['id']) && !in_array($targetToSave, $alreadyExistFiles)) {
                    if (!move_uploaded_file($_FILES['poster']['tmp_name'], $targetToSave)) {
                        $errorsMessage['poster'] = '<span class="invalid-feedback">L\'affiche n\'a pas été téléchargé.</span>';
                        $errorsClass['poster'] = 'is-invalid';
                    } elseif (count(array_filter($errorsMessage)) > 0) {
                        alert('Erreur lors de la création');
                    }
                    alert('Le film a été ajouté avec succès', 'success');
                    resizePoster($manager, $targetToSave);
                    $lastInsertedId = insertMovie($movieSlug, $targetToSave);
                    updateCategory($lastInsertedId);
                    header('Location: ' . $router->generate('library'));
                    exit();
                }
            }
        } elseif (!empty($isUpdate)) {
            alert('Le film a été modifié sans le poster', 'success');
            uploadMovieLessPoster($movieId);
            updateCategory($lastInsertedId);
            header('Location: ' . $router->generate('library'));
            exit();
        }
        alert('Merci d\'insérer une affiche');
        $errorsClass['poster'] = 'is-invalid';
    }
}
?>
