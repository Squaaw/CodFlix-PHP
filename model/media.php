<?php

require_once( 'database.php' );

class Media {

  protected $id;
  protected $genre_id;
  protected $title;
  protected $type;
  protected $status;
  protected $release_date;
  protected $summary;
  protected $trailer_url;

  public function __construct( $media ) {

    $this->setId( isset( $media->id ) ? $media->id : null );
    $this->setGenreId( $media->genre_id );
    $this->setTitle( $media->title );
  }

  /***************************
  * -------- SETTERS ---------
  ***************************/

  public function setId( $id ) {
    $this->id = $id;
  }

  public function setGenreId( $genre_id ) {
    $this->genre_id = $genre_id;
  }

  public function setTitle( $title ) {
    $this->title = $title;
  }

  public function setType( $type ) {
    $this->type = $type;
  }

  public function setStatus( $status ) {
    $this->status = $status;
  }

  public function setReleaseDate( $release_date ) {
    $this->release_date = $release_date;
  }

  /***************************
  * -------- GETTERS ---------
  ***************************/

  public function getId() {
    return $this->id;
  }

  public function getGenreId() {
    return $this->genre_id;
  }

  public function getTitle() {
    return $this->title;
  }

  public function getType() {
    return $this->type;
  }

  public function getStatus() {
    return $this->status;
  }

  public function getReleaseDate() {
    return $this->release_date;
  }

  public function getSummary() {
    return $this->summary;
  }

  public function getTrailerUrl() {
    return $this->trailer_url;
  }

  /***************************
  * -------- GET LIST --------
  ***************************/

  public static function getMediasByTitle( $title ) {

    // Open database connection
    $db   = init_db();

    $req  = $db->prepare( "SELECT * FROM media WHERE title LIKE ? ORDER BY title" );
    $req->execute( array( '%' . $title . '%' ));

    // Close databse connection
    $db   = null;

    return $req->fetchAll();

  }

    /***************************
  * -------- GET MEDIA DATA --------
  ***************************/

  public static function getMediasByType( $type ) {

    // Open database connection
    $db   = init_db();

    // Show movies or tv shows from last id to first id (from new inserts to old inserts).
    $req  = $db->prepare( "SELECT * FROM media WHERE type = ? ORDER BY id DESC");
    $req->execute( array( $type ));

    // Close database connection
    $db   = null;

    return $req->fetchAll();
  }

  public static function mediaDetails( $id ) {

    // Open database connection
    $db   = init_db();

    $req  = $db->prepare( "SELECT * FROM media WHERE id = ?" );
    $req->execute( array( $id ));

    // Close databse connection
    $db   = null;

    return $req->fetch();
  }

  public static function getGenreById( $id ) {

    // Open database connection
    $db   = init_db();

    $req  = $db->prepare( "SELECT name FROM genre WHERE id = ?" );
    $req->execute( array( $id ));

    // Close databse connection
    $db   = null;

    return $req->fetch();
  }

  public static function getAllGenre() {

    // Open database connection
    $db   = init_db();

    $req  = $db->prepare( "SELECT * FROM genre" );
    $req->execute();

    // Close databse connection
    $db   = null;

    return $req->fetchAll();
  }

  public static function getMediasByGenre( $genre_id ) {

    // Open database connection
    $db   = init_db();

    $req  = $db->prepare( "SELECT * FROM media WHERE genre_id = ?" );
    $req->execute( array( $genre_id ));

    // Close databse connection
    $db   = null;

    return $req->fetchAll();
  }

  public static function getMediasByReleaseDate( $release_date ) {

    // Open database connection
    $db   = init_db();

    $req  = $db->prepare( "SELECT * FROM media WHERE release_date LIKE ?" );
    $req->execute( array( '%' . $release_date . '%' ));

    // Close databse connection
    $db   = null;

    return $req->fetchAll();
  }

  public static function getAllReleaseDate() {

    // Open database connection
    $db   = init_db();

    $req  = $db->prepare( "SELECT DISTINCT SUBSTRING(release_date, 1, 4) AS year FROM `media` ORDER BY year DESC " );
    $req->execute();

    // Close databse connection
    $db   = null;

    return $req->fetchAll();
  }

  public static function getSeasonsByMediaId( $media_id ) {

    // Open database connection
    $db   = init_db();

    $req  = $db->prepare( "SELECT DISTINCT season FROM serie WHERE media_id = ?" );
    $req->execute( array( $media_id ));

    // Close databse connection
    $db   = null;

    return $req->fetchAll();
  }

  public static function getEpisodesByMediaId( $media_id, $season ) {

    // Open database connection
    $db   = init_db();

    $req  = $db->prepare( "SELECT episode FROM serie WHERE media_id = :media_id AND season = :season" );
    $req->execute( array(
      'media_id' => $media_id,
      'season' => $season
    ));

    // Close databse connection
    $db   = null;

    return $req->fetchAll();
  }

  public static function getEpisodesDetails( $media_id, $season, $episode ) {

    // Open database connection
    $db   = init_db();

    $req  = $db->prepare( "SELECT * FROM serie WHERE season = :season AND episode = :episode AND media_id = :media_id " );
    $req->execute( array(
      'media_id' => $media_id,
      'season' => $season,
      'episode' => $episode
    ));

    // Close databse connection
    $db   = null;

    return $req->fetch();
  }

  /***************************
  * -------- HISTORY --------
  ***************************/

  // Get all the media the user visited.
  public static function getVisitedMedias( $user_id ){
    // Open database connection
    $db   = init_db();

    $req  = $db->prepare( "SELECT * FROM history WHERE user_id = ? ORDER BY finish_date DESC" );
    $req->execute( array( $user_id ));

    // Close databse connection
    $db   = null;

    return $req->fetchAll();
  }

  public static function getOneVisitedMedia($user_id, $media_id){

        // Open database connection
        $db   = init_db();

        $req = $db->prepare("SELECT * FROM history where media_id = :media_id AND user_id = :user_id");
        $req->execute( array(
          'user_id' => $user_id,
          'media_id' => $media_id
        ));
    
        // Close databse connection
        $db   = null;
    
        return $req->fetch();
  }


  // Add the visited media to user's history list.
  public static function addMediaToHistory($user_id, $media_id){

    // Open database connection
    $db   = init_db();

    $req = $db->prepare("SELECT * FROM history where media_id = :media_id AND user_id = :user_id");
    $req->execute( array(
      'user_id' => $user_id,
      'media_id' => $media_id
    ));

    // If the user has not already visited this media
    if( $req->rowCount() <= 0 )
    {
      $req  = $db->prepare( "INSERT INTO history (user_id, media_id, start_date, finish_date, watch_duration) VALUES (:user_id, :media_id, :start_date, :finish_date, :watch_duration)" );
      $req->execute( array( 
        'user_id' => $user_id,
        'media_id' => $media_id,
        'start_date' => date("Y-m-d H:i:s"),
        'finish_date' => date("Y-m-d H:i:s"),
        'watch_duration' => '0'
      ));
    }
    else // Else, just update the last visit date.
    {
      $req = $db->prepare("UPDATE history SET finish_date = :finish_date WHERE user_id = :user_id AND media_id = :media_id");
      $req->execute( array(
        'finish_date' => date("Y-m-d H:i:s"),
        'user_id' => $user_id,
        'media_id' => $media_id
      ));
    }

    // Close databse connection
    $db   = null;
  }

  public static function updateWatchTime($user_id, $media_id, $watchtime){

    // Open database connection
    $db   = init_db();

    $req = $db->prepare("UPDATE history SET watch_duration = :watchtime WHERE user_id = :user_id AND media_id = :media_id");
      $req->execute( array(
        'watchtime' => (int)$watchtime,
        'user_id' => $user_id,
        'media_id' => $media_id
      ));

    // Close databse connection
    $db   = null;

  }

  public static function deleteAllHistory($user_id){

    // Open database connection
    $db   = init_db();

    $req = $db->prepare("DELETE FROM history WHERE user_id = ?");
    $req->execute( array( $user_id ));

    // Close databse connection
    $db   = null;
  }

  public static function deleteOneMedia($user_id, $media_id){

    // Open database connection
    $db   = init_db();

    $req = $db->prepare("DELETE FROM history WHERE user_id = :user_id AND media_id = :media_id");
    $req->execute( array( 
      'user_id' => $user_id,
      'media_id' => $media_id
    ));

    // Close databse connection
    $db   = null;
  }

    /***************************
  * -------- FAVORITES --------
  ***************************/

  public static function getAllFavorites($user_id){
    // Open database connection
    $db   = init_db();

    $req = $db->prepare("SELECT * FROM favorites WHERE user_id = ? ORDER BY id DESC");
    $req->execute( array( $user_id ));

    // Close databse connection
    $db   = null;

    return $req->fetchAll();
  }

  public static function getFavoriteByMedia($user_id, $media_id){
    // Open database connection
    $db   = init_db();

    $req = $db->prepare("SELECT * FROM favorites WHERE user_id = :user_id AND media_id = :media_id");
    $req->execute( array( 
      'user_id' => $user_id,
      'media_id' => $media_id
    ));

    // Close databse connection
    $db   = null;

    return $req->fetch();
  }

  public static function addMediaToFavorites($user_id, $media_id){
    // Open database connection
    $db   = init_db();

    // $req = getFavoriteByMedia($user_id, $media_id);

    $req = $db->prepare("SELECT * FROM favorites WHERE user_id = :user_id AND media_id = :media_id");
    $req->execute( array( 
      'user_id' => $user_id,
      'media_id' => $media_id
    ));

    // If the user has not this media in favorite yet, add it to the list.
    if( $req->rowCount() <= 0 )
    {
      $req = $db->prepare("INSERT INTO favorites (user_id, media_id) VALUES (:user_id, :media_id)");
      $req->execute( array( 
        'user_id' => $user_id,
        'media_id' => $media_id
      ));
    }
    else // Else, delete this media from the favorite list.
    {
      $req = $db->prepare("DELETE FROM favorites WHERE user_id = :user_id AND media_id = :media_id");
      $req->execute( array( 
        'user_id' => $user_id,
        'media_id' => $media_id
      ));
    }

    // Close databse connection
    $db   = null;
  }

  // public static function deleteOneFavorite($user_id, $media_id){
  //   // Open database connection
  //   $db   = init_db();

  //   $req = $db->prepare("DELETE FROM favorites WHERE user_id = :user_id AND media_id = :media_id");
  //   $req->execute( array( 
  //     'user_id' => $user_id,
  //     'media_id' => $media_id
  //   ));

  //   // Close databse connection
  //   $db   = null;
  // }

  public static function deleteAllFavorites($user_id){
    // Open database connection
    $db   = init_db();

    $req = $db->prepare("DELETE FROM favorites WHERE user_id = ?");
    $req->execute( array( $user_id ));

    // Close databse connection
    $db   = null;
  }

}
