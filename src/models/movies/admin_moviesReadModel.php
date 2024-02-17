<?php

$sql = 'SELECT * FROM movies';
$query = $db->query($sql);
$movies = $query->fetchAll(PDO::FETCH_ASSOC);

?>