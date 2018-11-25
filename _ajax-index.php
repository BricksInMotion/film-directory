<?php
require_once 'src/common-utils.php';
require_once 'src/classes/Index.php';
require_once 'src/classes/Film.php';


function render_films($films_list) {
  $html = '';

  foreach ($films_list as $v) {
    // Pull the director's name.
    //  We can't do this when pulling the year search results
    $director = (new Film($v->id))->get_director_info();

    $raw_html = file_get_contents('partials/film-index.html');
    $new_html = str_replace('|film-id|', $v->id, $raw_html);
    $new_html = str_replace('|film-title|', $v->title, $new_html);
    $new_html = str_replace('|film-thumbnail|', $v->thumbnail, $new_html);
    $new_html = str_replace('|film-release|', format_film_release_date($v->release_date), $new_html);
    $new_html = str_replace('|director|', $director->real_name, $new_html);
    $html .= $new_html;
  }

  return $html;
}

// Get the year we want to view
$index = new Index;
$ajax_data = escapeXSS(get_json('php://input')->year);

// Get and render the next chunk of film data
$film_data = $index->get_films_by_year_chunks($ajax_data);
$film_html = render_films($film_data);
echo $film_html;
exit;
