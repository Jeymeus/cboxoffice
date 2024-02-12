<?php get_header('Edit Films', 'admin'); ?>
<script>
    function previewPoster(input) {
        var file = input.files[0];
        var imgElement = document.getElementById('posterPreview');

        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                imgElement.src = e.target.result;
                imgElement.classList.remove('d-none'); // Retirer la classe d-none
            };
            reader.readAsDataURL(file);
        } else {
            imgElement.src = ''; // Effacer la source de l'image
            imgElement.classList.add('d-none'); // Ajouter la classe d-none
        }
    }
</script>
<script>
    function previewTrailer(input) {
        var trailerValue = input.value.trim();
        var iframeElement = document.getElementById('iframe');

        if (trailerValue !== '') {
            iframeElement.src = trailerValue;
            iframeElement.classList.remove('d-none'); // Retirer la classe d-none
        } else {
            iframeElement.src = ''; // Effacer la source de l'iframe
            iframeElement.classList.add('d-none'); // Ajouter la classe d-none
        }
    }
</script>


<style>
    html,
    body,
    .vertical-center {
        height: 100%;
    }

    .display {
        display: flex;
        flex-wrap: nowrap;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .movie_name {
        width: 55%;
    }

    .date,
    .duration,
    .note_press {
        width: 14%;
    }

    .poster,
    .trailer {
        width: 45%;
        margin-bottom: 20px;
    }

    .poster label,
    .trailer label {
        margin-left: 2%;
    }

    #iframe {
        width: 100%;
        height: 400px;
    }


    .form-signin {
        max-width: 1200px;
        padding: 1rem;
    }

    .form-signin .form-floating:focus-within {
        z-index: 2;
    }

    #floatingSynopsis {
        margin-bottom: 10px;
    }

    .d-none {
        display: none;
    }
</style>

<div class="d-flex align-items-center py-4 bg-body-tertiary vertical-center">
    <form class="form-signin w-100 m-auto" method="post" enctype="multipart/form-data">
        <h1 class="h3 mb-3 fw-normal text-center"><?= $formTitle; ?></h1>
        <div class="display">
            <div class="form-floating movie_name">
                <input type="text" class="form-control <?= $errorsClass['movie_name'] ?>" id="floatingMovieName" name="movie_name" placeholder="Nom du Film" value="<?= htmlentities($movieName); ?>">
                <label for="floatingMovieName">Nom du Film</label>
                <?= $errorsMessage['movie_name']; ?>
            </div>
            <div class="form-floating note_press">
                <input type="number" class="form-control <?= $errorsClass['note_press'] ?>" id="floatingNotePress" name="note_press" placeholder="Note de presse" min="0" max="10" step="0.1" value="<?= htmlentities($notePress); ?>">
                <label for="floatingNotePress" class="form-label">Note de presse</label>
                <?= $errorsMessage['note_press']; ?>
            </div>
            <div class="form-floating date">
                <input type="date" class="form-control <?= $errorsClass['date'] ?>" id="floatingDate" name="date" placeholder="Date de sortie" value="<?= htmlentities($date); ?>">
                <label for="floatingDate">Date de sortie</label>
                <?= $errorsMessage['date']; ?>
            </div>
            <div class="form-floating duration">
                <input type="texte" class="form-control <?= $errorsClass['duration'] ?>" id="floatingDuration" name="duration" value="<?= htmlentities($duration) ?>">
                <label for="floatingDuration">Durée</label>
                <?= $errorsMessage['duration']; ?>
            </div>
        </div>
        <div class="form-floating">
            <textarea class="form-control <?= $errorsClass['synopsis'] ?>" id="floatingSynopsis" name="synopsis" placeholder="Synopsis" style="height: 200px"><?= htmlentities($synopsis); ?></textarea>
            <label for="floatingSynopsis">Synopsis</label>
            <?= $errorsMessage['synopsis']; ?>
        </div>
        <div class="display">
            <div class="poster mb-4">
                <label for="floatingPoster">Affiche</label>
                <input type="file" class="form-control mb-2 <?= $errorsClass['poster'] ?>" id="floatingPosterInput" name="poster" onchange="previewPoster(this)">
                <img class="<?= $imgPoster ?>" id="posterPreview" src="<?= '/' . htmlentities($poster); ?>" alt="Affiche du film" style="max-width: 100%; height: auto;">
                <?= $errorsMessage['poster']; ?>
            </div>
            <div class="trailer mb-4">
                <label for="floatingTrailer">Bande Anonnce</label>
                <input type="text" class="form-control mb-2 <?= $errorsClass['trailer'] ?>" id="floatingTrailer" name="trailer" value="<?= htmlentities($trailer) ?>" onchange="previewTrailer(this)">
                <iframe id="iframe" src="<?= htmlentities($trailer) ?>" title="<?= htmlentities($movieName) ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                <?= $errorsMessage['trailer']; ?>
            </div>
        </div>
        <h4 class="mb-4">Catégories</h4>
        <?php foreach ($allCategory as $cat) {
            $checked = false;
            foreach ($categoryByMovies as $catMovie) {
                if ($cat->name == $catMovie->name) {
                    $checked = true;
                    break;
                }
            }
        ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input mb-4" type="checkbox" id="<?= htmlentities($cat->name); ?>" value="<?= htmlentities($cat->name); ?>" <?= $checked ? 'checked' : '' ?>>
                <label class="form-check-label" for="<?= htmlentities($cat->name); ?>"><?= htmlentities($cat->name); ?></label>
            </div>
        <?php } ?>

        <button class="btn btn-primary w-100 py-2" type="submit"><?= $submitButtonLabel; ?></button>
    </form>
</div>
</div>

<?php get_footer('login'); ?>