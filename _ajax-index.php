<?php
require_once 'src/common-utils.php';
require_once 'src/classes/Index.php';

// Get the year we want to view
$index = new Index;
$ajax_data = get_json('php://input');

// Get the next chunk of film data
$index->get_films_by_year_chunks($ajax_data->year);

// $film_data = ['films' => []];
// echo json_encode($film_data);
