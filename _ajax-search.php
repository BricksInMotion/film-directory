<?php
require_once 'src/common-utils.php';
require_once 'src/classes/Search.php';

// Search for the film
$ajax_data = escapeXSS(get_json('php://input')->query);
$results = Search::search_by_title($ajax_data);

echo $results;
exit;

