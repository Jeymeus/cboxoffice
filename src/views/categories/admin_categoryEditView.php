<?php get_header('Edit Category', 'admin'); ?>

<style>
    .cat {
        width: 20%;
    }

    #new-cat {
        width: 75%;
    }

    #btncat {
        height: 80%;
    }
</style>

<h1 class="mb-4">Categories</h1>
<div class="d-flex justify-content-between">
    <ul id="" class="list-group cat">
        <?php foreach ($allCategory as $cat) { ?>
            <li class="list-group-item "><?= htmlentities($cat->name); ?></li>
        <?php } ?>
    </ul>
    <form action="" id="new-cat" method="post">
        <div class="d-flex justify-content-between">
            <div class="form-floating duration mt-4">
                <input type="text" class="form-control <?= $errorsClass['category1'] ?>" id="floatingCategory1" name="category1" value="<?= htmlentities($category1) ?>">
                <label for="floatingCategory1">Nouvelle catégorie</label>
            </div>
            <div class="form-floating duration mt-4">
                <input type="text" class="form-control <?= $errorsClass['category2'] ?>" id="floatingCategory2" name="category2" value="<?= htmlentities($category2) ?>">
                <label for="floatingCategory2">Nouvelle catégorie</label>
            </div>
            <div class="form-floating duration mt-4">
                <input type="text" class="form-control <?= $errorsClass['category3'] ?>" id="floatingCategory3" name="category3" value="<?= htmlentities($category3) ?>">
                <label for="floatingCategory3">Nouvelle catégorie</label>
            </div>
        </div>
        <div id="btncat" class="d-flex justify-content-center align-items-center">
            <button type="submit" class="btn btn-primary">Ajouter Catégorie(s)</button>
        </div>
    </form>
</div>