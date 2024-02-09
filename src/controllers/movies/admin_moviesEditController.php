<?php

$errorsMessage = [
    'movie_name' => false,
    'date' => false,
    'duration' => false,
    'synopsis' => false,
    'poster' => false,
    'trailer' => false,
    'note_press' => false,
    'class' => false
];

$errorClasses = [
    'movie_name' => 'is-invalid',
    'date' => 'is-invalid',
    'duration' => 'is-invalid',
    'synopsis' => 'is-invalid',
    'poster' => 'is-invalid',
    'trailer' => 'is-invalid',
    'note_press' => 'is-invalid',
];

$globalMessage = [
    'class' => 'd-none',
    'message' => false
];

if (empty($_GET['id']) || empty($poster)) {
    $imgPoster = 'd-none';
}


if (!empty($_POST)) {
    $isUpdate = isset($_GET['id']) && is_numeric($_GET['id']);

    $movieName = getValue('movie_name');
    $notePress = getValue('note_press');
    $date = getValue('date');
    $duration = getValue('duration');
    $synopsis = getValue('synopsis');
    $trailer = getValue('trailer');


    // Validation du titre du film
    if (empty($movieName)) {
        $errorsMessage['movie_name'] = '<span class="invalid-feedback">Le titre du film est obligatoire.</span>';
        $errorsMessage['class'] = 'is-invalid';
    } else {
        // Si un ID est passé et que le titre existe déjà mais ne correspond pas à celui de l'ID
        if (!empty($_GET['id'])) {
            $existingTitle = checkAlreadyExistTitle($_GET['id']);
            if ($existingTitle == true) {
                $errorsMessage['movie_name'] = '<span class="invalid-feedback">Le titre du film existe déjà.</span>';
                $errorsMessage['class'] = 'is-invalid';
            }
        }
    }

    $movieSlug = renameFile($movieName);

    // Validation de la date du film
    if (empty($date)) {
        $errorsMessage['date'] = '<span class="invalid-feedback">La date du film est obligatoire.</span>';
        $errorsMessage['class'] = 'is-invalid';
    } else {
        $parsedDate = date_parse($date);
        if (!$parsedDate || $parsedDate['error_count'] > 0 || !checkdate($parsedDate['month'], $parsedDate['day'], $parsedDate['year'])) {
            $errorsMessage['date'] = '<span class="invalid-feedback">Veuillez saisir une date valide.</span>';
            $errorsMessage['class'] = 'is-invalid';
        }
    }

    // Validation de la durée du film
    if (empty($duration)) {
        $errorsMessage['duration'] = '<span class="invalid-feedback">La durée du film est obligatoire.</span>';
        $errorsMessage['class'] = 'is-invalid';
    } else {
        $regexDuration = '/^\d{1,3}$/';
        if (!preg_match($regexDuration, $duration)) {
            $errorsMessage['duration'] = '<span class="invalid-feedback">Veuillez saisir une durée en minutes.</span>';
            $errorsMessage['class'] = 'is-invalid';
        }
    }

    // Validation du synopsis du film
    if (empty($synopsis)) {
        $errorsMessage['synopsis'] = '<span class="invalid-feedback">Le synopsis du film est obligatoire.</span>';
        $errorsMessage['class'] = 'is-invalid';
    }

    // Validation de la note de presse
    if (isset($notePress) && !empty($notePress)) {
        $regexDuration = '/^(?:10|\d(?:\.\d{1,2})?)$/';
        if (!preg_match($regexDuration, $notePress)) {
            $errorsMessage['note_press'] = '<span class="invalid-feedback">Veuillez saisir une note comprise entre 0 et 10, séparée par un point.</span>';
            $errorsMessage['class'] = 'is-invalid';
        }
    } else {
        $errorsMessage['note_press'] = '<span class="invalid-feedback">La note est obligatoire.</span>';
        $errorsMessage['class'] = 'is-invalid';
    }
    if (count(array_filter($errorsMessage)) == 0) {
        
        
        if (!empty($_FILES['poster']['name'])) {
            
            
            $uploadPath = 'uploads';

            $uploadResult = uploadFile($uploadPath, 'poster');

            if (!empty($uploadResult['messagePoster'])) {
                $errorsMessage['poster'] = '<span class="invalid-feedback">' . $uploadResult['messagePoster'] . '</span>';
                $errorsMessage['class'] = 'is-invalid';
            } else if (!empty($uploadResult['path'])) {

                $targetToSave = $uploadResult['path'];
                $alreadyExistFiles = checkAlreadyExistFile($targetToSave);
                // If the film exists and ID not,
                if (in_array($targetToSave, $alreadyExistFiles) && !isset($_GET['id'])) {
                    $errorsMessage['poster'] = '<span class="invalid-feedback">Le nom de l\'affiche existe déjà.</span>';
                    $errorsMessage['class'] = 'is-invalid';
                }
                // If the film and ID exist, upload without poster
                elseif (in_array($targetToSave, $alreadyExistFiles) && isset($_GET['id'])) {
                    // Check if the film's ID matches his poster
                    $movie = getMovieById($_GET['id']);
                    if ($movie && $movie['poster'] === $targetToSave) {
                        if (count(array_filter($errorsMessage)) > 0) {
                            alert('Erreur lors de la modification');
                        }
                        alert('Le film a été modifié avec succès', 'success');
                        uploadMovieLessPoster($movieId);
                    } else {
                        // If the ID doesn't match the poster, 
                        $errorsMessage['poster'] = '<span class="invalid-feedback">Une affiche du même nom existe.</span>';
                        $errorsMessage['class'] = 'is-invalid';
                    }
                }
                // If ID exists and the film does not exist, complete upload
                elseif (isset($_GET['id']) && !in_array($targetToSave, $alreadyExistFiles)) {
                    if (!move_uploaded_file($_FILES['poster']['tmp_name'], $targetToSave)) {
                        $errorsMessage['poster'] = '<span class="invalid-feedback">L\'affiche n\'a pas été téléchargé.</span>';
                        $errorsMessage['class'] = 'is-invalid';
                    } elseif (count(array_filter($errorsMessage)) > 0) {
                        alert('Erreur lors de la modification');
                    }
                    alert('Le film a été modifié avec succès', 'success');
                    resizePoster($manager, $targetToSave);
                    updateMovie($movieId, $targetToSave);
                }
                // If ID and film do not exist, insertion
                elseif (!isset($_GET['id']) && !in_array($targetToSave, $alreadyExistFiles)) {
                    if (!move_uploaded_file($_FILES['poster']['tmp_name'], $targetToSave)) {
                        $errorsMessage['poster'] = '<span class="invalid-feedback">L\'affiche n\'a pas été téléchargé.</span>';
                        $errorsMessage['class'] = 'is-invalid';
                    } elseif (count(array_filter($errorsMessage)) > 0) {
                        alert('Erreur lors de la création');
                    }
                    alert('Le film a été ajouté avec succès', 'success');
                    resizePoster($manager, $targetToSave);
                    insertMovie($movieSlug, $targetToSave);
                }
            }
        } elseif (!empty($isUpdate)) {
            alert('Le film a été modifié sans le poster', 'success');
            uploadMovieLessPoster($movieId);
        }
        // alert('Merci d\'insérer une affiche');
    }
}

