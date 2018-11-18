<?php
$pageTitle = 'View Film';
require_once 'src/db-connect.php';
require_once 'partials/head.php';
require_once 'partials/header.php';
require_once 'src/classes/Film.php';
require_once 'src/common_utils.php';

// TODO: XSS/invalid arg check
$film = new Film($_GET['film_id']);
$film_info = $film->get_film_info();
$director = $film->get_director_info();
?>

<main>
  <section class="film-info">
    <div class="image">
      <img class="film-thumbnail" alt="Film thumbnail" src="film-images/<?= $film_info->thumbnail; ?>">
    </div>

    <div class="info">
      <h2><?= $film_info->title; ?></h2>
      <span><strong>Directed By</strong>: <a href="director.php?director_id=<?= $director->user_id; ?>"><?= $director->real_name; ?> (<small><?= $director->user_name; ?></small>)</a></span><br>
      <span><strong>Released</strong>: <?= format_film_release_date($film_info->release_date); ?></span><br>
      <span><strong>Runtime</strong>: <?= format_film_runtime($film_info->length); ?></span><br>
      <div class="film-genres"><strong>Genres</strong>:
        <?php
        foreach ($film->get_genres() as $record):
          echo "<span class='genre'>{$record->genre}</span>";
        endforeach;
        ?>
      </div>
      <?php $film_rating = $film->get_rating(); ?>
      <span><strong>Rating</strong>: <?= $film_rating->rating; ?>/5 (out of <?= $film_rating->total_votes; ?> <?= $film_rating->word; ?>)</span><br>
      <div class="film-warnings"><strong>Content Advisory</strong>:
        <?php
        foreach ($film->get_warnings() as $value):
          $str = "<span class='warning |severity|'>|capital_severity| |type|</span>";
          $str = str_replace('|severity|', $value['severity'], $str);
          $str = str_replace('|capital_severity|', ucfirst($value['severity']), $str);
          $str = str_replace('|type|', $value['type'], $str);
          echo $str;
        endforeach;
        ?>
      </div>
    </div>

    <section class="film-links">
      <h3>Watch</h3>
      <div>
        <?php
        foreach ($film->get_links() as $record):
          echo "<span class='link'><a href='{$record->link}' target='_blank'>{$record->label}</a></span>";
        endforeach;
        ?>
      </div>
    </section>
  </section>

  <section class="film-desc">
    <h3>Director's Description</h3>
    <blockquote><?= convert_bb_code($film_info->desc); ?></blockquote>
  </section>

  <section class="film-cast-crew">
    <h3>Cast &amp; Crew</h3>
    <h3>Staff Ratings</h3>
    <h3>Honors</h3>
  </section>

  <section class="film-reviews">
    <h3>Staff Reviews</h3>
    <?php
    foreach ($film->get_reviews() as $record): ?>
    <blockquote>
      <strong><?= $record->real_name; ?></strong>
      <p><?= convert_bb_code($record->comments); ?></p>
    </blockquote>
    <?php endforeach; ?>
  </section>
</main>

<?php require 'partials/footer.php'; ?>
</body>
</html>
