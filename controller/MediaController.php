<?php

require_once( 'model/media.php' );

/***************************
* ----- LOAD MEDIA PAGE -----
***************************/

function mediaPage() {

  if ( !empty( $_GET['media'] )) mediaDetails(); // If a specific media id is set, show this media details.
  else showMedia(); // Otherwise, show all media.

}

function showMedia(){

  $years = Media::getAllReleaseDate();
  $genres = Media::getAllGenre();

  $search = null;

  if (!empty($_GET['title']))
  {
    $search = $_GET['title'];
  }
  elseif (!empty($_GET['type']))
  {
    $search = $_GET['type'];
  }
  elseif (!empty($_GET['genre']))
  {
    $search = $_GET['genre'];
  }
  elseif (!empty($_GET['release_date']))
  {
    $search = $_GET['release_date'];
  }

  // If search bar is not empty, show results.
  if (!empty($search))
  {
    if (isset($_GET['title'])){
      $medias = Media::getMediasByTitle($search);
    }
    elseif (isset($_GET['type'])){
      $medias = Media::getMediasByType($search);
    }   
    elseif (isset($_GET['genre'])){
      $medias = Media::getMediasByGenre($search);
    }  
    elseif (isset($_GET['release_date'])){
      $medias = Media::getMediasByReleaseDate($search);
    }
  }
  else // If no keywords within the search bar, show all movies and tv shows.
  {
    $movies = Media::getMediasByType("film");
    $series = Media::getMediasByType("série");
  }

  require_once('view/mediaListView.php');
}

function mediaDetails(){
  
  $user_id = isset( $_SESSION['user_id'] ) ? $_SESSION['user_id'] : false;
  
  // Add the media to the history list if it is the first time the user visited this media.
  Media::addMediaToHistory($user_id, $_GET['media']);

  $isFavorite = Media::getFavoriteByMedia($user_id, $_GET['media']);

  if (isset($_GET['favorite']) && $_GET['favorite'] == 'true')
  {
    Media::addMediaToFavorites($user_id, $_GET['media']);
    $isFavorite = !$isFavorite;
  }

  if (isset($_GET['watchtime'])){
    Media::updateWatchTime($user_id, $_GET['media'], $_GET['watchtime']);
  }

  // Get data of a specific media (movie or tv show).
  $media = Media::mediaDetails($_GET['media']);
  $getGenre = Media::getGenreById($media['genre_id']);
  $genre = $getGenre['name'];
  $video = $media['trailer_url']; // Set the default stream url.
  $getHistoryMedia = Media::getOneVisitedMedia($user_id, $media['id']);
  $watchtime = $getHistoryMedia['watch_duration']; // Get the watched time from the last session.

  $episodeDetails = false;

  // Get number of seasons and episodes of a specific tv show.
  if ($media['type'] == 'série')
  {
    $seasons = Media::getSeasonsByMediaId($media['id']);
    $episodes = null;

    // Get specific data about an episode.
    if (isset($_GET['season']) && isset($_GET['episode']))
    {
      $episodeDetails = Media::getEpisodesDetails( $_GET['media'], $_GET['season'], $_GET['episode'] );
      if ($episodeDetails) $video = $episodeDetails['stream_url']; // Set the episode stream url.
    }
    elseif (isset($_GET['season']))
    {
      $episodes = Media::getEpisodesByMediaId($media['id'], $_GET['season']);
    }
  }

  require_once('view/mediaDetailsView.php');
}
