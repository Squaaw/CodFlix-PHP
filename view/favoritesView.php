<?php ob_start(); ?>

<script>
    function deleteFavorite(str){
        document.getElementById('deleteOneFavorite').value = str;
    }
</script>

<form method="post" action="index.php?action=favorites" class="custom-form">
    <div class="row">
        <h1 class="media-header col-md-10">Mes favoris</h1>
        <?php if ($favorites): ?>
            <input type="submit" name="deleteAllFavorites" value="Supprimer tous mes favoris" class="btn btn-block bg-red col-md-2 text-white" />
        <?php endif; ?>
    </div>

    <div class="media-list">
        <?php
            if ($favorites):
            foreach( $favorites as $row ):
                $media = Media::mediaDetails($row['media_id']);
        ?>
            <a class="item" href="index.php?media=<?= $media['id']; ?>">
                <div class="video">
                    <div>
                        <!-- <iframe allowfullscreen="" frameborder="0"
                                src="<?= $media['trailer_url']; ?>" ></iframe> -->
                                <img src="<?= $media['poster_url']; ?>" width="100%" />
                    </div>
                </div>
                <div class="title"><?= $media['title']; ?></div>              
                <div class="d-flex justify-content-center"><span class="badge badge-light"><?= substr($media['release_date'], 0, 4) ?></span></div>
                <div class="d-flex justify-content-center mt-2">
                    <input type="submit" value="Supprimer" onclick="deleteFavorite(<?= $media['id'] ?>)" class="btn btn-block bg-red text-white col-md-3 p-1" />
                </div>
            </a>
                       
        <?php endforeach; else: ?>
        <h3 class="mt-3">Vous n'avez ajouté aucun média en favoris pour le moment.</h3>
        <?php endif; ?>
    </div>

    <input type="hidden" name="deleteOneFavorite" id="deleteOneFavorite">
</form>


<?php $content = ob_get_clean(); ?>

<?php require('dashboard.php'); ?>