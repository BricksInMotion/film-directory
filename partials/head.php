<?php
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?= $pageTitle; ?> | Bricks in Motion Film Directory Archive</title>
  <meta name="theme-color" content="#10141f">
  <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:500,700|Montserrat:400,400i,700">
  <link rel="stylesheet" href="/css/style.css">
  <?php
    if (isset($pageStyles)):
      foreach ($pageStyles as $css):
        echo "<link rel='stylesheet' href='/css/{$css}'>\n";
      endforeach;
    endif;
    ?>
</head>

<body class="<?= str_replace(' ', '-', strtolower($pageTitle)); ?>">