<?php
require_once 'src/common-utils.php';
require_once 'src/classes/Search.php';

$BLACKLIST = ['', 'a', 'an', 'the', 'of', 'for'];


function no_results_found() {
  return file_get_contents('partials/search-results-none.html');
}


function render_search_results($results) {
  // There were no search results
  if (count($results) === 0) return no_results_found();

  $html = '';
  foreach ($results as $v) {
    $raw_html = file_get_contents('partials/search-results.html');
    $new_html = str_replace('|film-id|', $v->id, $raw_html);
    $new_html = str_replace('|film-title|', $v->title, $new_html);
    $html .= $new_html;
  }

  return $html;
}

// Search for the film
$ajax_data = escapeXSS(get_json('php://input')->query);

// We are not searching these huge queries
if (in_array($ajax_data, $BLACKLIST)) {
  echo no_results_found();
  exit;
}

// Search and render the results
$results = Search::search_by_title($ajax_data);
$rendered = render_search_results($results);
echo $rendered;
exit;
