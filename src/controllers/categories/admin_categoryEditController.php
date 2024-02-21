<?php

$_SESSION['movieName'] = $movieName;
$_SESSION['notePress'] = $notePress;
$_SESSION['date'] = $date;
$_SESSION['duration'] = $duration;
$_SESSION['synopsis'] = $synopsis;
$_SESSION['trailer'] = $trailer;


$category1 = '';
$category2 = '';
$category3 = '';

$errorsClass = [
'category1' => false,
'category2' => false,
'category3' => false,
];

if (!empty($_POST)) {
    $category1 = getValue('category1');
    $category2 = getValue('category2');
    $category3 = getValue('category3');
    $regexCategory = '/^[a-zA-Z\s\-]+$/';

    if (!empty($category1)) {
        if (preg_match($regexCategory, $category1)) {
            if (!categoryExists($category1)) {
                insertCategory($category1);
            } else {
                $errorsClass['category1'] = 'is-invalid';
                alert('La catégorie existe déjà.');
            }
        } else {
            $errorsClass['category1'] = 'is-invalid';
            alert('La catégorie n\'est pas valide.');
        }
    }

    if (!empty($category2)) {
        if (preg_match($regexCategory, $category2)) {
            if (!categoryExists($category2)) {
                insertCategory($category2);
            } else {
                $errorsClass['category2'] = 'is-invalid';
                alert('La catégorie existe déjà.');
            }
        } else {
            $errorsClass['category2'] = 'is-invalid';
            alert('La catégorie n\'est pas valide.');
        }
    }

    if (!empty($category3)) {
        if (preg_match($regexCategory, $category3)) {
            if (!categoryExists($category3)) {
                insertCategory($category3);
            } else {
                $errorsClass['category3'] = 'is-invalid';
                alert('La catégorie existe déjà.');
            }
        } else {
            $errorsClass['category3'] = 'is-invalid';
            alert('La catégorie n\'est pas valide.');
        }
    }

    if (empty($category1) && empty($category2) && empty($category3)) {
        alert('Merci de renseigner au moins un champ.');
    }
}