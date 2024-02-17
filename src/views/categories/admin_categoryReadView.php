<?php
get_header('Edit Films', 'admin');
?>


<style>
    .wrapper {
        max-width: 1550px;
        margin: 0 auto;
    }

    .movie-table {
        width: 50%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .movie-table th,
    .movie-table td {
        padding: 10px;
        text-align: left;
        border-left: 1px solid #444;
        border-right: 1px solid #444;
    }

    .movie-table tr td:last-child {
        border-left: none;
    }

    .movie-table thead th {
        background-color: #333;
        color: white;
    }

    .movie-table tbody tr:nth-child(even) {
        background-color: #999;
    }

    .movie-table tbody tr:nth-child(odd) {
        background-color: orange;
    }

    .movie-table tbody tr:hover {
        background-color: #ccc;
    }

    .action-cell {
        text-align: center !important;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        align-items: center;
        border: none;
    }

    .btn {
        padding: 5px 10px;
        margin-right: 5px;
        color: white;
        border: none;
        cursor: pointer;
    }

    .large {
        width: 110px;
    }
</style>



<div class="wrapper">
    <table class="movie-table">
        <thead>
            <tr>
                <th>Nom</th>
                <th class="action-cell">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $cat) : ?>
                <tr>
                    <!-- htmlentities pour pse protéger contre la fail XSS -->
                    <td><?= htmlentities($cat['name']); ?></td>
                    <td class=" action-buttons">
                        <a class="btn btn-danger" href="<?= $router->generate('categoryDelete', ['id' =>  htmlentities($cat['id'])]); ?>">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<?php get_footer('login'); ?>