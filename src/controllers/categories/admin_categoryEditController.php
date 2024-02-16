<?php

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
insertCategory($category1);
} else {
$errorsClass['category1'] = 'is-invalid';
alert('La catégorie 1 n\'est pas valide.');
}
}

if (!empty($category2)) {
if (preg_match($regexCategory, $category2)) {
insertCategory($category2);
} else {
$errorsClass['category2'] = 'is-invalid';
alert('La catégorie 2 n\'est pas valide.');
}
}

if (!empty($category3)) {
if (preg_match($regexCategory, $category3)) {
insertCategory($category3);
} else {
$errorsClass['category3'] = 'is-invalid';
alert('La catégorie 3 n\'est pas valide.');
}
}

if (empty($category1) && empty($category2) && empty($category3)) {
alert('Merci de renseigner au moins un champ.');
}
}