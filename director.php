<?php
$pageTitle = 'View Director';
require_once 'src/db-connect.php';
require_once 'partials/head.php';
require_once 'partials/header.php';
require_once 'src/classes/Director.php';
// require_once 'src/common_utils.php';

// TODO: XSS/invalid arg check
$director = new Director($_GET['director_id']);
// TODO: if director_id === 0 OR id has no record, no director found
?>
