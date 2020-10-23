<?php ob_start(); ?>

<script>
function getGenre(str) {
  if (str != "") {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("mainContainer").innerHTML = this.responseText;
      }
    };

    xmlhttp.open("GET","index.php?genre=" + str, true);
    xmlhttp.send();  
  }
}

function getYear(str) {
  if (str != "") {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("mainContainer").innerHTML = this.responseText;
      }
    };

    xmlhttp.open("GET","index.php?release_date=" + str, true);
    xmlhttp.send();  
  }
}

function getType(str) {
  if (str != "") {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("mainContainer").innerHTML = this.responseText;
      }
    };

    xmlhttp.open("GET","index.php?type=" + str, true);
    xmlhttp.send();  
  }
}

function getTitle() {
    let keyword = document.getElementById('search').value;

  if (keyword != "") {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("mainContainer").innerHTML = this.responseText;
      }
    };

    xmlhttp.open("GET","index.php?title="+keyword, true);
    xmlhttp.send();
  }
}
</script>

<select name="genre" id="genre" onchange="getGenre(this.value)">
    <option value="">Genre</option>
    <?php foreach( $genres as $genre ): ?>
        <option value="<?= $genre['id'] ?>"><?= $genre['name'] ?></option>
    <?php endforeach; ?>
</select>

<select name="year" id="year" onchange="getYear(this.value)">
    <option value="">Années</option>
    <?php foreach( $years as $year ): ?>
        <option value="<?= $year['year'] ?>"><?= $year['year'] ?></option>
    <?php endforeach; ?>
</select>

<select name="type" id="type" onchange="getType(this.value)">
    <option value="">Type</option>
    <option value="film">Film</option>
    <option value="serie">Série</option>
</select>

<div class="row">
    <div class="col-md-4 offset-md-8">
            <div class="form-group has-btn">
                <input type="search" id="search" name="title" value="" class="form-control" placeholder="Rechercher un film ou une série">
                <button type="submit" class="btn btn-block bg-red" onclick="getTitle()">Valider</button>
            </div>
    </div>
</div>

<!-- If search bar is empty, show all medias (movies and TV shows) -->
<?php if (empty($search)): ?>

    <h1 class="movies-header">FILMS</h1>
    <div class="media-list">
        <?php foreach( $movies as $movie ): ?>
            <a class="item" href="index.php?media=<?= $movie['id']; ?>">
                <div class="video">
                    <div>
                        <!-- <iframe allowfullscreen="" frameborder="0"
                                src="<?= $movie['trailer_url']; ?>" ></iframe> -->
                                <img src="<?= $movie['poster_url']; ?>" width="100%" />
                    </div>
                </div>
                <div class="title"><?= $movie['title']; ?></div>              
                <div class="d-flex justify-content-center"><span class="badge badge-light"><?= substr($movie['release_date'], 0, 4) ?></span></div>
            </a>
        <?php endforeach; ?>
    </div>

    <h1 class="series-header">SERIES</h1>
    <div class="media-list">
        <?php foreach( $series as $serie ): ?>
            <a class="item" href="index.php?media=<?= $serie['id']; ?>">
                <div class="video">
                    <div>
                        <!-- <iframe allowfullscreen="" frameborder="0"
                                src="<?= $serie['trailer_url']; ?>" ></iframe> -->
                                <img src="<?= $serie['poster_url']; ?>" width="100%" />
                    </div>
                </div>
                <div class="title"><?= $serie['title']; ?></div>
                <div class="d-flex justify-content-center"><span class="badge badge-light"><?= substr($serie['release_date'], 0, 4) ?></span></div>
            </a>
        <?php endforeach; ?>
    </div>

<?php endif; ?>

<!-- If search bar is not empty, show all medias containing the keyword(s) -->
<?php if (!empty($search)): ?>

    <h1 class="search-header">VOTRE RECHERCHE</h1>
    <div class="media-list">
        <?php foreach( $medias as $media ): ?>
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
            </a>
        <?php endforeach; ?>
    </div>

<?php endif; ?>


<?php $content = ob_get_clean(); ?>

<?php require('dashboard.php'); ?>
