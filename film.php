<?php
$pageTitle = 'View Film';
$pageStyles = ['style-film.css'];

require_once 'partials/head.php';
require_once 'partials/header.php';
require_once 'src/common-utils.php';
require_once 'src/classes/Film.php';


$film_id = escapeXSS($_GET['film_id']);
$film = new Film($film_id);

// Get out of here if the film doesn't exist
if ($film->get_film_exists() === false) {
  redirect_url('404.php');
}

$film_info = $film->get_film_info();
$director = $film->get_director_info();
?>

<main>
  <section class="film-info">
    <div class="thumbnail">
      <img alt="Film thumbnail" src="film-images/<?= $film_info->thumbnail; ?>">
    </div>

    <div class="details">
      <h2><?= $film_info->title; ?></h2>
      <span><strong>Directed By</strong>: <a href="director.php?director_id=<?= $director->user_id; ?>"><?= $director->real_name; ?> <small>(<?= $director->user_name; ?>)</small></a></span><br>
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
        foreach ($film->get_warnings() as $warning):
          $str = "<span class='warning |severity|'>|capital_severity| |type|</span>";
          $str = str_replace('|severity|', $warning['severity'], $str);
          $str = str_replace('|capital_severity|', ucfirst($warning['severity']), $str);
          $str = str_replace('|type|', $warning['type'], $str);
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

  <section class="film-critiques">
    <div class="film-cast-crew">
      <h3>Cast &amp; Crew</h3>
      <?php
        foreach ($film->get_cast_crew() as $job):
          echo "<div>
            <a href='director.php?director_id={$job->cc_user_id}'>{$job->name}</a>
            <span>{$job->crewname}</span>
          </div>";
        endforeach;
        ?>
    </div>

    <div class="film-honors">
      <h3>Honors</h3>
      <span><?= $film->get_honors(); ?></span>
    </div>

    <div class="film-staff-ratings">
      <h3>Staff Ratings</h3>
      <?php
        foreach ($film->get_staff_ratings() as $sr):
          echo "<div class='{$sr->class}'>
            <strong>{$sr->category}</strong>
            <span>{$sr->rating}</span>
          </div>";
        endforeach;
        ?>
    </div>
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
