<?php

$sql = 'SELECT * FROM category';
$query = $db->query($sql);
$categories = $query->fetchAll(PDO::FETCH_ASSOC);

?>

