<?php

class Director {
  public $id = 0;

  function __construct($id) {
    $this->id = (int) $id;
  }

  /**
   * Determine if the director exists.
   *
   * @return {bool}
   */
  function get_director_exists() {
    // Short circuit the lookup if the ID is zero
    // Zero is being used to indicate an unknown director
    if ($this->id === 0) return false;

    require 'src/db-connect.php';
    $stmt = $pdo->prepare('SELECT
    1
    FROM `films_users`
    WHERE `films_users`.`user_id`= ?
    LIMIT 1');
    $stmt->execute([$this->id]);
    return (bool) $stmt->fetch(PDO::FETCH_OBJ);
  }
}
