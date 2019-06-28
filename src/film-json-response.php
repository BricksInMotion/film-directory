<?php
require_once 'src/common-utils.php';
require_once 'src/classes/Film.php';


/**
 * Create a JSON object containing film info,
 * tailored for Reborn-style film entries.
 *
 * @param $film {Film}
 * @return {array}
 */
function build_film_json($film) {
  $film_data = [
    // We know the film exists at this point
    // because that check was run before we got here
    'exists' => true
  ];

  // Load the film info, but remove needed data
  $film_data['info'] = $film->get_film_info();
  unset($film_data['info']->title);
  unset($film_data['info']->thumbnail);
  unset($film_data['info']->length);

  // Format the film to be pretty printed
  $film_data['info']->release_date = format_film_release_date(
    $film_data['info']->release_date
  );

  // Add the film advisories and links
  $film_data['advisories'] = $film->get_advisories();
  $film_data['links'] = $film->get_links();

  return $film_data;
}
