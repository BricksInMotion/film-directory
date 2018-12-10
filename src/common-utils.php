<?php
/**
 * Escape any characters that could facilitate an XSS attack vector.
 *
 * @param {string} $text - The raw string to be escaped.
 * @return {string} The escaped string.
 */
function escape_xss($text) {
  // Correctly handle non-breaking spaces
  $text = trim($text, chr(0xC2).chr(0xA0));
  $text = str_replace("&nbsp;", "", $text);
  return htmlentities(strip_tags(trim($text)));
}


function convert_bb_code($text) {
  $start_bb_tags = ['[b]', '[i]'];
  $start_html_tags = ['<strong>', '<em>'];
  $end_bb_tags = ['[/b]', '[/i]'];
  $end_html_tags = ['</strong>', '</em>'];

  // Sanitize the data and convert the BBCode tags to HTML
  $text = escape_xss($text);
  $text = str_replace($start_bb_tags, $start_html_tags, $text);
  $text = str_replace($end_bb_tags, $end_html_tags, $text);
  return nl2br(trim($text));
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
  // This film has an unknown release date
  if (strpos($date, '1900') === 0) {
    return 'Unknown';
  }

  $dt = new DateTime($date);
  return $dt->format('F jS, Y');
}

function redirect_url($url) {
  header("Location: {$url}");
  exit;
}

function render_film_list($roles) {
  $final = '<ul class ="role-list">';
  foreach ($roles as $role) {
    $final .= "<li>
    <a href='film.php?film_id={$role->id}'>{$role->title}</a> <small>({$role->year_released})</small><br>
    <div class='role-single'>{$role->role}</div>
    </li>";
  }
  $final .= '</ul>';
  return $final;
}

function get_json($path) {
  return json_decode(file_get_contents($path), false);
}
