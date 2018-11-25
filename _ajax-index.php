<?php
require_once 'src/common-utils.php';
require_once 'src/classes/Index.php';


function render_films($films_list) {
  $html = '';

  foreach ($films_list as $film) {
    $html .= "<div class='film-{$film->id}'>
      <img class='film-thumbnail' src='film-images/{$film->thumbnail}'>
      <a href='film.php?film_id={$film->id}'>{$film->title}</a>
      <span>{$film->release_date}</span>
    </div>";
  }

  return $html;
}

// Get the year we want to view
$index = new Index;
$ajax_data = get_json('php://input');

// Get and render the next chunk of film data
$film_data = $index->get_films_by_year_chunks($ajax_data->year);
$film_html = render_films($film_data);
echo $film_html;
exit;
