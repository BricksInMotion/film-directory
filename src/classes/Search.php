<?php
class Search {
  /**
   * Search for a film by title.
   */
  static function search_by_title($query) {
    require_once 'src/db-connect.php';

    $stmt = $pdo->prepare('SELECT
    `films`.`id`,
    `films`.`title`
    FROM `films`
    WHERE `films`.`title` LIKE CONCAT("%", ?, "%")
    ORDER BY `films`.`id` ASC');
    $stmt->execute([$query]);
    $films = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $films;
  }
}
