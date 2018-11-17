<?php
function convert_bb_code($str) {
  $start_bb_tags = ['[b]', '[i]'];
  $start_html_tags = ['<strong>', '<em>'];
  $end_bb_tags = ['[/b]', '[/i]'];
  $end_html_tags = ['</strong>', '</em>'];

  $str = str_replace($start_bb_tags, $start_html_tags, $str);
  $str = str_replace($end_bb_tags, $end_html_tags, $str);
  return trim($str);
}

function format_film_runtime($seconds) {
  // https://stackoverflow.com/a/3856312
  $hours = floor($seconds / 3600);
  $mins = floor($seconds / 60 % 60);
  $secs = floor($seconds % 60);

  // Only display the hours if needed
  if ($hours > 0) {
    return sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
  }
  return sprintf('%02d:%02d', $mins, $secs);
}

function format_film_release_date($date) {
  $dt = new DateTime($date);
  return $dt->format('F jS, Y');
}