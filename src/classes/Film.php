<?php

class Film {
  public $id = 0;

  function __construct($id) {
    $this->id = $id;
  }

  /**
   * Get the film's basic info.
   */
  function get_film_info() {
    require 'src/db-connect.php';

    $stmt = $pdo->prepare('SELECT
    `title`,
    `user_desc` AS `desc`,
    `img_thumb` AS `thumbnail`,
    `lenth` AS `length`,
    `date_create` AS `release_date`
    FROM `films`
    WHERE `films`.`id`= ?
    LIMIT 1');
    $stmt->execute([$this->id]);
    return $stmt->fetch(PDO::FETCH_OBJ);
  }

  /**
   * Get the film director's info.
   */
  function get_director_info() {
    require 'src/db-connect.php';

    $stmt = $pdo->prepare('SELECT
    `films_users`.`user_id`,
    `user_name`,
    `real_name`
    FROM `films_users`
    INNER JOIN `films` ON `films`.`user_id` = `films_users`.`user_id`
    WHERE `films`.`id` = ?
    LIMIT 1');
    $stmt->execute([$this->id]);
    $info = $stmt->fetch(PDO::FETCH_OBJ);

    // The user id that submitted this film doesn't exist
    // Provide dummy info that indicates such
    if ($info === false) {
      $fake_info = new stdClass();
      $fake_info->user_id = '0';
      $fake_info->user_name = 'N/A';
      $fake_info->real_name = 'Unknown';
      return $fake_info;
    }
    return $info;
  }

  /**
   * Get the film's rating.
   */
  function get_rating() {
    require 'src/db-connect.php';

    // This query calculates the film's rating as well as handles
    // the (likely common) case where a film does not have a rating.
    // It's a big ugly because once upon a time, someone thought
    // the best value to represent a lack of a rating would be NULL,
    // when 0 would have worked better, so we have to pay for the sins of the past
    $stmt = $pdo->prepare('SELECT
    `total_votes`,
    ROUND(`total_value` / `total_votes`, 2) AS `raw_rating`,
    (SELECT IF(ISNULL(`raw_rating`), FORMAT(0, 0), `raw_rating`)) AS `rating`,
    IF(`total_votes` >= 0, "ratings", "rating") AS `word`
    FROM `films_user_rate`
    WHERE `films_user_rate`.`id` = CONCAT("film", ?)');
    $stmt->execute([$this->id]);
    return $stmt->fetch(PDO::FETCH_OBJ);
  }

  /**
   * Get all links to the film.
   */
  function get_links() {
    require 'src/db-connect.php';

    $stmt = $pdo->prepare('SELECT `link`, `link_desc` AS `label`
    FROM `films_links`
    WHERE `film_id`= ?');
    $stmt->execute([$this->id]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  /**
   * Get all user reviews of the film.
   */
  function get_reviews() {
    require 'src/db-connect.php';

    $stmt = $pdo->prepare('SELECT `films_users`.`real_name`, `comments`
    FROM `films_reviews`
    INNER JOIN `films_users` ON `films_reviews`.`userid` = `films_users`.`user_id`
    WHERE `films_reviews`.`filmid` = ?');
    $stmt->execute([$this->id]);
    $reviews = $stmt->fetchAll(PDO::FETCH_OBJ);

    // This film has no reviews, provide text that says so
    if (count($reviews) === 0) {
      $reviews = new stdClass();
      $reviews->real_name = 'This film has not been reviewed!';
      $reviews->comments = '';

      // We expect an array containing `stdClass`es,
      // so we need to replicate that here
      $reviews = [$reviews];
    }
    return $reviews;
  }

  /**
   * Get the film's genres.
   */
  function get_genres() {
    require 'src/db-connect.php';

    $stmt = $pdo->prepare('SELECT `genre`
    FROM `genres`
    INNER JOIN `films_genre` ON `genres`.`id` = `films_genre`.`genres_id`
    WHERE `films_genre`.`film_id` = ?');
    $stmt->execute([$this->id]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  /**
   * Get the film's warnings, if any.
   */
  function get_warnings() {
    require 'src/db-connect.php';

    $stmt = $pdo->prepare('SELECT `warn_sex`, `warn_lang`, `warn_vio`
    FROM `films`
    WHERE `id`= ?');
    $stmt->execute([$this->id]);
    $warnings = $stmt->fetch(PDO::FETCH_ASSOC);

    // Filter out any columns that indicate no warning
    $warnings = array_filter($warnings, function($v) {
      return $v !== 0;
    });

    // This film has no warnings
    $results = new stdClass();
    if (count($warnings) === 0) {
      $results->none = [
        'type' => 'advisory',
        'severity' => 'no'
      ];
      return $results;
    }

    // Define proper labels based on values in the db
    $types = [
      'warn_vio' => 'violence',
      'warn_lang' => 'language',
      'warn_sex' => 'sexual content'
    ];
    $severity = [
      1 => 'mild',
      2 => 'moderate',
      3 => 'strong'
    ];

    // Collect the film's warnings
    foreach ($warnings as $key => $value) {
      $type = $types[$key];
      $results->$type = [
        'type' => $type,
        'severity' => $severity[$value]
      ];
    }
    return $results;
  }

  /**
   * Get the film's cast and crew.
   */
  function get_cast_crew() {
    require 'src/db-connect.php';

    // Get the predefined roles
    // Both this query and the query for custom-defined roles
    // must take into account the `name` column being NULL
    // because the person being referenced has a record
    // in the `films_users` table and their /(user|real)_name/ is used for
    // their name instead of it being stored in the `films_castcrew` table,
    // as it is when the person is _not_ a registered user.
    // This adds some complexity to the query but allows us to
    // pull all the data we need in one swoop.
    // Man, I _LOVE_ half-designed, half-organically grown databases!! /s
    $stmt = $pdo->prepare('SELECT
    `films_crewtype`.`crewname`,
    `name` AS `raw_name`,
    IF(ISNULL(`user_id`), 0, `user_id`) AS `cc_user_id`,
    (SELECT `real_name` FROM `films_users` WHERE `cc_user_id` = `films_users`.`user_id`) AS `raw_user_name`,
    (SELECT IF(ISNULL(`raw_name`), `raw_user_name`, `raw_name`)) AS `name`
    FROM `films_castcrew`
    INNER JOIN `films_crewtype` ON `films_castcrew`.`job` = `films_crewtype`.`id`
    WHERE `job` < 8 AND `film_id` = ?
    ORDER BY `job` ASC');
    $stmt->execute([$this->id]);
    $standard_roles = $stmt->fetchAll(PDO::FETCH_OBJ);

    // Get the custom-defined roles, again taking into account
    // the /(user|real)_name/ data location difference
    $stmt = $pdo->prepare('SELECT
    `cast` AS `crewname`,
    `name` AS `raw_name`,
    IF(ISNULL(`user_id`), 0, `user_id`) AS `cc_user_id`,
    (SELECT `real_name` FROM `films_users` WHERE `cc_user_id` = `films_users`.`user_id`) AS `raw_user_name`,
    (SELECT IF(ISNULL(`raw_name`), `raw_user_name`, `raw_name`)) AS `name`
    FROM `films_castcrew`
    INNER JOIN `films_crewtype` ON `films_castcrew`.`job` = `films_crewtype`.`id`
    WHERE `job` >= 8 AND `film_id` = ?
    ORDER BY `job` ASC');
    $stmt->execute([$this->id]);
    $custom_roles = $stmt->fetchAll(PDO::FETCH_OBJ);

    // Merge the two arrays and drop the temporary (`raw_`) keys
    $all_roles = array_merge($standard_roles, $custom_roles);
    array_map(function($k) {
      unset($k->raw_name);
      unset($k->raw_user_name);
      return $k;
    }, $all_roles);
    return $all_roles;
  }

  function get_staff_ratings() {
    require 'src/db-connect.php';

  }


  function get_honors() {
    require 'src/db-connect.php';

  }
}
