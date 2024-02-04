<?php get_header('Edit Films', 'admin');
dump($movieId)?>

<style>
    .info-title {
        color: #4285f4;
        font-size: 18px;
    }

    .info-content {
        font-weight: bold;
    }

    #display {
        display: flex;
        flex-wrap: nowrap;
        justify-content: space-around;
        align-items: center;
        margin-bottom: 10px;

    }
</style>

<div class="d-flex align-items-center py-4 bg-body-tertiary vertical-center">
    <div class="form-signin w-100 m-auto">
        <h1 class="h3 mb-3 fw-normal text-center">Supprimer un film</h1>
        <div id="display">
            <div class="deleteContent">
                <div class="form-floating movie_name" style="margin-bottom: 10px;">
                    <h2 class="info-title">Nom du Film</h2>
                    <p class="info-content"><?= $movieName; ?></p>
                </div>
                <div class="form-floating note_press" style="margin-bottom: 10px;">
                    <h2 class="info-title">Note de presse</h2>
                    <p class="info-content"><?= $notePress; ?></p>
                </div>
                <div class="form-floating date" style="margin-bottom: 10px;">
                    <h2 class="info-title">Date de sortie</h2>
                    <p class="info-content"><?= $date; ?></p>
                </div>
                <div class="form-floating duration" style="margin-bottom: 10px;">
                    <h2 class="info-title">Durée</h2>
                    <p class="info-content"><?= $duration; ?></p>
                </div>
                <div class="form-floating">
                    <h2 class="info-title">Synopsis</h2>
                    <p class="info-content"><?= $synopsis; ?></p>
                </div>
            </div>
            <div class="deleteBtn">
                <form method="get" action="">
                    <input type="hidden" name="movieId" value="<?= $movieId; ?>">
                    <div class="deleteBtn">
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>