<?php

require '../common-utils.php';


class Search {
  /**
   * Search for a film by title.
   */
  static function search_by_title($query) {
    $q = escapeXSS($query);

    $stmt = $pdo->prepare('SELECT
    `films`.`id`,
    `films`.`title`
    FROM `films`
    WHERE `films`.`title` LIKE "%?%"
    ORDER BY `films`.`id` ASC');
    $stmt->execute([$q]);
    $films = $stmt->fetchAll(PDO::FETCH_OBJ);
  }
}
