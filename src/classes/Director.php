<?php

class Director {
  public $id = 0;

  function __construct($id) {
    $this->id = (int) $id;
  }

  /**
   * @private
   *
   * Helper method to pull info for roles with a common structure.
   *
   * @return {stdClass}
   */
  private function get_role($role) {
    require 'src/db-connect.php';

    // $defined_roles = [
    //   'director' => '1',
    //   'writer'   => '2',
    //   'composer' => '3',
    //   'animator' => '4',
    //   'editor'   => '5',
    //   'vfx'      => '6',
    //   'sound'    => '7',
    //   'other'    => '8',
    //   'thanks'   => '9',
    //   'va'       => '10'
    // ];

    $stmt = $pdo->prepare('SELECT
    `films`.`id`,
    `films`.`title`,
    YEAR(`films`.`date_create`) AS `year_released`,
    IF(`cast` = "", "", `cast`) AS `role`
    FROM `films_castcrew`
    INNER JOIN `films` ON `films`.`id` = `film_id`
    WHERE `films_castcrew`.`user_id`= ? AND `job` = ?
    ORDER BY `films`.`date_create` DESC');
    $stmt->execute([$this->id, $role]);
    $results = $stmt->fetchAll(PDO::FETCH_OBJ);

    // Handle a lack of films for this role
    $total = count($results);
    if ($total === 0) {
      $info = new stdClass();
      $info->id = '0';
      $info->title = 'No films available';
      $info->role = '';
      $info->year_released = 'N/A';
      $results[] = $info;
    }

    // Add query info to returned results
    $info = new stdClass();
    $info->total = $total;
    $info->word = $total != 1 ? 'films' : 'film';
    $results[] = $info;
    return $results;
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

  /**
   * Get the director information.
   *
   * @return {stdClass}
   */
  function get_director_info() {
    require 'src/db-connect.php';

    $stmt = $pdo->prepare('SELECT
    `user_name`,
    `real_name`
    FROM `films_users`
    WHERE `films_users`.`user_id`= ?
    LIMIT 1');
    $stmt->execute([$this->id]);
    return $stmt->fetch(PDO::FETCH_OBJ);
  }

  /**
   * Get the director's animator role.
   *
   * @return {stdClass}
   */
  function get_role_animator() {
    return $this->get_role('4');
  }

  /**
   * Get the director's composer role.
   *
   * @return {stdClass}
   */
  function get_role_composer() {
    return $this->get_role('3');
  }

  /**
   * Get the director's crew role.
   *
   * @return {stdClass}
   */
  function get_role_crew() {
    return $this->get_role('8');
  }

  /**
   * Get the director's director role.
   *
   * @return {stdClass}
   */
  function get_role_director() {
    return $this->get_role('1');
  }

  /**
   * Get the director's editor role.
   *
   * @return {stdClass}
   */
  function get_role_editor() {
    return $this->get_role('5');
  }

  /**
   * Get the director's sound editing role.
   *
   * @return {stdClass}
   */
  function get_role_sound() {
    return $this->get_role('7');
  }

  /**
   * Get the director's special thanks role.
   *
   * @return {stdClass}
   */
  function get_role_thanks() {
    return $this->get_role('9');
  }

  /**
   * Get the director's visual effects role.
   *
   * @return {stdClass}
   */
  function get_role_vfx() {
    return $this->get_role('6');
  }

  /**
   * Get the director's voice actor role.
   *
   * @return {stdClass}
   */
  function get_role_voice() {
    return $this->get_role('10');
  }

  /**
   * Get the director's writer role.
   *
   * @return {stdClass}
   */
  function get_role_writer() {
    return $this->get_role('2');
  }
}
