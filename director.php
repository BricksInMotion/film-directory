<?php
$pageTitle = 'View Director';
require_once 'src/db-connect.php';
require_once 'partials/head.php';
require_once 'partials/header.php';
require_once 'src/common-utils.php';
require_once 'src/classes/Director.php';


// TODO: Invalid arg check
$director_id = escapeXSS($_GET['directorid']);
$director = new Director($director_id);
// TODO: if director_id === 0 OR id has no record, no director found
?>
