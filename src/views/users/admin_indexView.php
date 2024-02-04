<?php get_header('Liste des utilisateurs', 'admin'); ?>

<style>
    .movie-table {
        width: 100%;
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


    .action-buttons {
        display: flex;
        justify-content: space-around;
        align-items: center;
        border: none;
    }
</style>

<h2>Liste des utilisateurs</h2>

<a href="<?= $router->generate('addUser'); ?>" class="btn btn-success">Ajouter</a>

<table class="movie-table">
    <thead>
        <tr>
            <th scope="col">Email</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td class="align-middle"><?= htmlentities($user->email); ?></td>
                <td class=" action-buttons">
                    <a class="btn btn-secondary" href="<?= $router->generate('editUser', ['id' =>  htmlentities($user->id)]); ?>">Editer</a>
                    <a class="btn btn-danger" href="<?= $router->generate('deleteUser', ['id' =>  htmlentities($user->id)]); ?>">Supprimer</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php get_footer('admin'); ?>

