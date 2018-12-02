<?php
class Film {
  public $id = 0;

  function __construct($id) {
    $this->id = (int) $id;
  }

  /**
   * Determine if the film exists.
   *
   * @return {bool}
   */
  function get_film_exists() {
    // Short circuit the lookup if the ID is zero
    // Zero is being used to indicate an unknown film
    if ($this->id === 0) return false;

    require 'src/db-connect.php';
    $stmt = $pdo->prepare('SELECT
    1
    FROM `films`
    WHERE `films`.`id`= ?
    LIMIT 1');
    $stmt->execute([$this->id]);
    return (bool) $stmt->fetch(PDO::FETCH_OBJ);
  }

  /**
   * Get the film's basic info.
   *
   * @return {stdClass}
   */
  function get_film_info() {
    require 'src/db-connect.php';

    $stmt = $pdo->prepare('SELECT
    `title`,
    `user_desc` AS `desc`,
    `img_thumb` AS `thumbnail`,
    `length`,
    `date_create` AS `release_date`
    FROM `films`
    WHERE `films`.`id`= ?
    LIMIT 1');
    $stmt->execute([$this->id]);
    return $stmt->fetch(PDO::FETCH_OBJ);
  }

  /**
   * Get the film director's info.
   *
   * @return {stdClass}
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

    // The director id that submitted this film doesn't exist
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
   *
   * @return {stdClass}
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
   *
   * @return {stdClass}
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
   *
   * @return {array}
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
      $reviews->real_name = 'This film has not been reviewed';
      $reviews->comments = '';

      // We expect an array of `stdClass`es,
      // so we need to replicate that here
      $reviews = [$reviews];
    }
    return $reviews;
  }

  /**
   * Get the film's genres.
   *
   * @return {stdClass}
   */
  function get_genres() {
    require 'src/db-connect.php';

    $stmt = $pdo->prepare('SELECT `genre`
    FROM `films_all_genres`
    INNER JOIN `films_genre` ON `films_all_genres`.`id` = `films_genre`.`genres_id`
    WHERE `films_genre`.`film_id` = ?');
    $stmt->execute([$this->id]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  /**
   * Get the film's warnings, if any.
   *
   * @return {stdClass}
   */
  function get_warnings() {
    require 'src/db-connect.php';

    $stmt = $pdo->prepare('SELECT `warn_lang`, `warn_vio`, `warn_sex`
    FROM `films`
    WHERE `id`= ?');
    $stmt->execute([$this->id]);
    $warnings = $stmt->fetch(PDO::FETCH_ASSOC);

    // Filter out any columns that indicate no warning
    $warnings = array_filter($warnings, function($v) {
      return $v !== '0';
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
      '1' => 'mild',
      '2' => 'moderate',
      '3' => 'strong'
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
   *
   * @return {array}
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
    `name` AS `raw_db_name`,
    IF(ISNULL(`user_id`), 0, `user_id`) AS `cc_user_id`,
    (SELECT `real_name` FROM `films_users` WHERE `cc_user_id` = `films_users`.`user_id`) AS `raw_user_name`,
    (SELECT IF(ISNULL(`raw_db_name`), `raw_user_name`, `raw_db_name`)) AS `raw_name`,
    (SELECT IF(ISNULL(`raw_name`), "Unknown", `raw_name`)) AS `name`
    FROM `films_castcrew`
    INNER JOIN `films_crewtype` ON `films_castcrew`.`job` = `films_crewtype`.`id`
    WHERE `job` < 8 AND `film_id` = ?
    ORDER BY `job` ASC');
    $stmt->execute([$this->id]);
    $standard_roles = $stmt->fetchAll(PDO::FETCH_OBJ);

    // Get the custom-defined roles, again taking into account
    // the /(user|real)_name/ data location difference
    $stmt = $pdo->prepare('SELECT
    IF(`cast` = "", `crewdesc`, `cast`) AS `crewname`,
    `name` AS `raw_db_name`,
    IF(ISNULL(`user_id`), 0, `user_id`) AS `cc_user_id`,
    (SELECT `real_name` FROM `films_users` WHERE `cc_user_id` = `films_users`.`user_id`) AS `raw_user_name`,
    (SELECT IF(ISNULL(`raw_db_name`), `raw_user_name`, `raw_db_name`)) AS `raw_name`,
    (SELECT IF(ISNULL(`raw_name`), "Unknown", `raw_name`)) AS `name`
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
      unset($k->raw_db_name);
      unset($k->raw_user_name);
      return $k;
    }, $all_roles);
    return $all_roles;
  }

  /**
   * Get the film's staff ratings.
   *
   * @return {array}
   */
  function get_staff_ratings() {
    require 'src/db-connect.php';

    // BTW, never generate primary IDs like this table has.
    // Add a new column to the rows each with a unique number
    // indicating what each category represents. _Please._
    // Having to use a regex to select the records is... bad
    $stmt = $pdo->prepare('SELECT
    `id`,
    ROUND(`total_value` / `total_votes`, 1) AS `raw_rating`,
    (SELECT IF(ISNULL(`raw_rating`), "N/A", `raw_rating`)) AS `rating`
    FROM films_user_rate
    WHERE id REGEXP CONCAT("^rev..", ?, "$")');
    $stmt->execute([$this->id]);
    $raw_ratings = $stmt->fetchAll(PDO::FETCH_OBJ);

    // There are no ratings for this film
    if (count($raw_ratings) === 0) {
      $indv = new stdClass();
      $indv->class = 'single';
      $indv->category = '';
      $indv->rating = 'No ratings given';

      // We expect an array of `stdClass`es,
      // so we need to replicate that here
      return [$indv];
    }

    // Define the rating categories
    $categories = [
      'Ov' => 'Overall',
      'St' => 'Story',
      'An' => 'Animation',
      'Ci' => 'Cinematography',
      'Ef' => 'Effects',
      'So' => 'Sound',
      'Mu' => 'Music'
    ];

    // Extract the ratings for this film
    $final_ratings = [];
    foreach ($raw_ratings as $rating) {
      $indv = new stdClass();

      // Extract the rating category ID from the record ID and
      // associate each category with the proper rating
      // Get the negative length of the film ID for proper slicing
      $slice_end = -strlen($this->id);
      $review_code = substr($rating->id, 3, $slice_end);
      $indv->class = '';
      $indv->category = $categories[$review_code];
      $indv->rating = $rating->rating;
      $final_ratings[] = $indv;
    }
    return $final_ratings;
  }

  /**
   * Get the film's given honors.
   *
   * @return {string}
   */
  function get_honors() {
    require 'src/db-connect.php';

    $stmt = $pdo->prepare('SELECT CAST(`review_stat` AS CHAR) AS `review_stat`
    FROM `films`
    WHERE `id` = ?');
    $stmt->execute([$this->id]);
    $r = $stmt->fetch(PDO::FETCH_OBJ);

    // Get the proper honor's label
    $honors = [
      '1' => 'No honors given',
      '2' => 'No honors given',
      '3' => "Reviewer's Pick",
      '4' => 'Staff Favorite'
    ];
    return $honors[$r->review_stat];
  }
}
