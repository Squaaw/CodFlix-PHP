<?php ob_start(); ?>

<script>

let selectedSeason = null;

function getSeason(str) {
  if (str == "") {
    document.getElementById("mainContainer").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("mainContainer").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","index.php?media=" + <?= $media['id']; ?> + "&season=" + str, true);
    xmlhttp.send();

    selectedSeason = str;
  }
}

function getEpisode(str) {
  if (str == "") {
    document.getElementById("mainContainer").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("mainContainer").innerHTML = this.responseText;
      }
    };

    xmlhttp.open("GET","index.php?media=" + <?= $_GET['media']; ?> + "&season=" + selectedSeason + "&episode=" + str, true);
    xmlhttp.send();
  }
}

function addFavorite(id){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        // document.getElementById("mainContainer").innerHTML = this.responseText;
      }
    };

    xmlhttp.open("GET","index.php?media=" + <?= $_GET['media']; ?> + "&favorite=true", true);
    xmlhttp.send();

    if (id == "btnAddTrue"){
      document.getElementById(id).style.display = 'none';
      document.getElementById('btnDeleteFalse').style.display = 'block';
    }
    else if (id == "btnDeleteFalse"){
      document.getElementById(id).style.display = 'none';
      document.getElementById('btnAddTrue').style.display = 'block';
    }
    else if (id == 'btnAddFalse'){
      document.getElementById(id).style.display = 'none';
      document.getElementById('btnDeleteTrue').style.display = 'block';
    }
    else if (id == 'btnDeleteTrue'){
      document.getElementById(id).style.display = 'none';
      document.getElementById('btnAddFalse').style.display = 'block';
    }
}

</script>

<?php if ($media['type'] == 'film'): ?>
<!-- 1. The <iframe> (and video player) will replace this <div> tag. -->
<div id="player"></div>

<script>
  // 2. This code loads the IFrame Player API code asynchronously.
  var tag = document.createElement('script');

  tag.src = "https://www.youtube.com/iframe_api";
  var firstScriptTag = document.getElementsByTagName('script')[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

  // 3. This function creates an <iframe> (and YouTube player)
  //    after the API code downloads.
  var player;
  function onYouTubeIframeAPIReady() {
    player = new YT.Player('player', {
      height: '700px',
      width: '100%',
      videoId: '<?php echo $video ?>' ,
      events: {
        'onReady': onPlayerReady,
        'onStateChange': onPlayerStateChange
      }
    });
  }

  // 4. The API will call this function when the video player is ready.
  function onPlayerReady(event) {
    document.getElementById("ytPlayerDuration").innerHTML = 'Durée : ' + getVideoDuration(player.getDuration());
  }

  var done = false;

  function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.PLAYING && !done){
      player.seekTo(<?= $watchtime ?>, true); // Get watched time while playing the video when the user left for the last time.
      done = true;
    }

    if (event.data == YT.PlayerState.PAUSED){
      saveCurrentWatchtime(player.getCurrentTime());
    }
  }

  // Get the total duration of the media (in hour and minutes).
  function getVideoDuration(seconds){
      d = Number(seconds);
      var h = Math.floor(d / 3600);
      var m = Math.floor(d % 3600 / 60);
      var s = Math.floor(d % 3600 % 60);

      var hDisplay = h < 10 ? "0" + h + "h" : h + "h";
      var mDisplay = m < 10 ? "0" + m : m;

      return hDisplay + mDisplay;
  }

  // Save the current watchtime into the database when the video is paused.
  function saveCurrentWatchtime(str) {
    if (str != "") {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          // document.getElementById("mainContainer").innerHTML = this.responseText;
        }
      };

      xmlhttp.open("GET","index.php?media=" + <?= $_GET['media']; ?> + "&watchtime=" + str, true);
      xmlhttp.send();
    }
}
</script>
<?php endif; ?>

<?php if ($media['type'] == 'série'): ?>
  <div style="width: 100%; height: 700px;">
      <iframe width="100%" height="100%" src="<?= $video ?>" frameborder="0" 
          allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
      </iframe>
  </div>
<?php endif; ?>

<div class="mt-3">

<div class="row">
    <div class="col-md-12">
    <span style="font-weight: bold;" id="ytPlayerDuration"></span>
            <div class="form-group has-btn">

              <h1 class="mb-2" id="test"><?= $media['title']; ?></h1>

              <?php if (!$isFavorite){ ?>
                <button type="submit" class="btn btn-block bg-red" id="btnAddTrue" onclick="addFavorite('btnAddTrue')" style="width: auto;">Ajouter aux favoris</button>
                <button type="submit" class="btn btn-block bg-dark" id="btnDeleteFalse" onclick="addFavorite('btnDeleteFalse')" style="width: auto; display: none;">Retirer des favoris</button>
              <?php }else{ ?>
                <button type="submit" class="btn btn-block bg-red" id="btnAddFalse" onclick="addFavorite('btnAddFalse')" style="width: auto; display: none;">Ajouter aux favoris</button>
                <button type="submit" class="btn btn-block bg-dark" id="btnDeleteTrue" onclick="addFavorite('btnDeleteTrue')" style="width: auto;">Retirer des favoris</button>
              <?php } ?>

            </div>
    </div>
</div>

    <?php if ($episodeDetails): ?>
        <h5 class="mb-3">
            <span style="text-decoration: underline;"><?= $episodeDetails['title'] ?></span>         
        </h5>
        <span>
            (Saison <?= $episodeDetails['season'] ?>, Episode <?= $episodeDetails['episode'] ?>)
        </span>
    <?php endif; ?>

    <?php if ($episodeDetails): ?>
        <p class="mb-3 text-justify"> <?= $episodeDetails['summary']; ?> </p>
    <?php else: ?>
        <p class="mb-3 text-justify"> <?= $media['summary']; ?> </p>
    <?php endif; ?>

    <?php if ($media['type'] == 'film'): ?>
        <a href="index.php?type=film" class="badge badge-primary p-2">film</a>
    <?php endif; ?>

    <?php if ($media['type'] == 'série'): ?>
        <a href="index.php?type=serie" class="badge badge-danger p-2">série</a>
    <?php endif; ?>

    <a href="index.php?release_date=<?= substr($media['release_date'], 0, 4); ?>" class="badge badge-info p-2"> <?= substr($media['release_date'], 0, 4); ?> </a>
    <a href="index.php?genre=<?= $media['genre_id'] ?>" class="badge badge-dark p-2"> <?= $genre ?> </a>

    <!-- If the media is a tv show, then show the different seasons and episodes -->
    <?php if ($media['type'] == 'série'): ?>

        <form method="get" class="custom-form">
            <input type="hidden" name="media" value="<?= $media['id'] ?>"/>

            <div class="row">
                <div class="mt-3 col-md-1">
                    <select name="season" id="season" onchange="getSeason(this.value)">
                        <option value="">Saisons</option>
                        <?php foreach( $seasons as $season ): ?>
                                <option id="season<?= $season['season'] ?>" value="<?= $season['season']; ?>">Saison <?= $season['season']; ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php if ($episodes): ?>
                    <div class="mt-3 col-md-1">
                        <select name="episode" id="episode" onchange="getEpisode(this.value)">
                        <option value="">Episodes</option>
                            <?php foreach( $episodes as $episode ): ?>
                                <option value="<?= $episode['episode']; ?>">Episode <?= $episode['episode']; ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>

            </div>
        </form>

    <?php endif; ?>

</div>

<?php $content = ob_get_clean(); ?>

<?php require('dashboard.php'); ?>