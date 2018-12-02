<?php
session_start();

class Index {
  private $start_id;
  private $current_year;
  private $chunk_size = 9;
  private $total_films = 0;

  function __construct() {
    (int) $this->start_id = (
      isset($_SESSION['start_id']) ? $_SESSION['start_id'] : null
    );
    $this->current_year = (
      isset($_SESSION['current_year']) ? $_SESSION['current_year'] : null
    );
  }

  /**
   * Get the first film for the given year.
   *
   * @return {integer}
   */
  private function get_first_film($year) {
    require 'src/db-connect.php';
    $stmt = $pdo->prepare('SELECT
    `films`.`incrementor`
    FROM `films`
    WHERE YEAR(`films`.`date_create`) = ?
    ORDER BY `films`.`date_create`
    LIMIT 1');
    $stmt->execute([$year]);
    return $stmt->fetch(PDO::FETCH_OBJ)->incrementor;
  }

  /**
   * @static
   *
   * Get the release dates of the films in the director.
   * NOTE: This list is gererated by a query. DO NOT EDIT!!
   */
  static function get_film_years() {
    return [
      'Unknown' => '1900',
      '1989' => '1989',
      '1990' => '1990',
      '2000' => '2000',
      '2001' => '2001',
      '2002' => '2002',
      '2003' => '2003',
      '2004' => '2004',
      '2005' => '2005',
      '2006' => '2006',
      '2007' => '2007',
      '2008' => '2008',
      '2009' => '2009',
      '2010' => '2010',
      '2011' => '2011',
      '2012' => '2012',
      '2013' => '2013',
      '2014' => '2014',
      '2015' => '2015',
      '2016' => '2016',
      '2017' => '2017',
      '2018' => '2018'
    ];
  }

  /**
   * Get the films for the given year, in stable sized chunks.
   *
   * @param {strong} - $year
   * @return {array}
   */
  function get_films_by_year_chunks($year) {
    require 'src/db-connect.php';

    // These are films that have no proper release date
    if ($year === '1900') {
      // We've not loaded this year before, set a custom start id
      if ($year !== $this->current_year) {
        $this->start_id = 1;
        $this->current_year = $year;
      }

      // Store the start id and year
      $_SESSION['start_id'] = $this->start_id;
      $_SESSION['current_year'] = $year;
    }

    // Only get the start ID if we've not got it already
    // or we're browsing a different year
    // This block is not hit the year is unknown
    if (is_null($this->start_id) || $year !== $this->current_year) {
      $this->start_id = $this->get_first_film($year);
      $this->current_year = $year;
      (int) $_SESSION['start_id'] = $this->start_id;
      $_SESSION['current_year'] = $year;
    }

    // Calcuate the end ID for this chunk
    $end_id = $this->start_id + $this->chunk_size;

    // Let's _finally_ pull the data
    $stmt = $pdo->prepare('SELECT
    `films`.`id`,
    `films`.`title`,
    `films`.`img_thumb` AS `thumbnail`,
    `films`.`date_create` AS `release_date`
    FROM `films`
    WHERE YEAR(`films`.`date_create`) = ? AND `films`.`incrementor` BETWEEN ? AND ?
    ORDER BY `films`.`date_create` ASC, `films`.`incrementor` ASC');
    $stmt->execute([$year, $this->start_id, $end_id]);
    $films = $stmt->fetchAll(PDO::FETCH_OBJ);

    // Update the state with the new start ID for the next chunk
    $_SESSION['start_id'] = $end_id + 1;
    return $films;
  }
}
