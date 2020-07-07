<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'src/common-utils.php';
require_once 'src/classes/Api.php';


// Fetch the film info
$qs_data = [
  'id' => escape_xss($_GET['id']),
  'props' =>'all'
];
$request = Api::get(Api::make_url('film', $qs_data));

// Handle requesting a non-existant film ID
if ($request->ok) {
  $film = load_json($request->response);
} else {
  redirect_url('404.php');
}

// Fetch the director info
$request = Api::get(Api::make_url('director', ['id' => $film->info->user_id]));
$director = load_json($request->response);

// Fetch the film rating info
$request = Api::get(Api::make_url('rating', ['id' => $film->info->id]));
$film_rating = load_json($request->response);

// Set the page info
$pageTitle = $film->info->title;
$pageStyles = ['style-film.css'];

// Start loading the page
require_once 'partials/head.php';
require_once 'partials/header.php';
?>

<main>
  <?php require 'partials/navi.html'; ?>

  <section class="film-info">
    <div class="thumbnail">
      <img class="film-thumbnail" alt="<?= htmlspecialchars($film->info->title); ?>" src="/film-images/<?= $film->info->thumbnail; ?>">
    </div>

    <div class="details">
      <h2><?= $film->info->title; ?></h2>
      <span><strong>Directed By</strong>: <a href="/director.php?id=<?= $director->id; ?>"><?= $director->user_name; ?></a></span><br>
      <span><strong>Released</strong>: <?= format_film_release_date($film->info->release_date); ?></span><br>
      <span><strong>Runtime</strong>: <?= format_film_runtime($film->info->runtime); ?></span><br>
      <div class="film-genres"><strong>Genres</strong>:
        <?php
        foreach ($film->genres as $genre):
          echo '<span class="genre">' . $genre . '</span>';
        endforeach;
        ?>
      </div>
      <span>
        <?php $word = intval($film_rating->rating->total_votes) !== 1 ? 'votes' : 'vote'; ?>
        <strong>Rating</strong>: <?= $film_rating->rating->rating; ?>/5 (out of <?= $film_rating->rating->total_votes; ?> <?= $word; ?>)
      </span>
      <br>
      <div class="film-warnings"><strong>Content Advisory</strong>:
        <?php
        foreach ($film->advisories as $advisory):
          $str = "<span class=\"warning |severity|\">|capital_severity| |type|</span>";
          $str = str_replace('|severity|', $advisory->severity, $str);
          $str = str_replace('|capital_severity|', ucfirst($advisory->severity), $str);
          $str = str_replace('|type|', $advisory->type, $str);
          echo $str;
        endforeach;
        ?>
      </div>
    </div>

    <section class="film-links">
      <h3>Watch</h3>
      <div>
        <?php
        if (count($film->links) === 0):
          echo 'No links available';
        endif;
        foreach ($film->links as $record):
          echo "<span class=\"link\"><a href=\"{$record->url}\" target=\"_blank\">{$record->label}</a></span>";
        endforeach;
        ?>
      </div>
    </section>
  </section>

  <section class="film-desc">
    <h3>Director's Description</h3>
    <blockquote><?= convert_bb_code($film->info->description); ?></blockquote>
  </section>

  <section class="film-critiques">
    <div class="film-cast-crew">
      <h3>Cast &amp; Crew</h3>
      <?php
        foreach ($film->cast_crew as $job):
          // Break up the crew name for people with multiple roles
          $job_crewname = str_replace('/', '<br>', $job->role, $count);
          echo "<div>
            <a href=\"director.php?id={$job->user_id}\">{$job->description}</a>
            <span class=\"crewname\">{$job->user_name}</span>
          </div>";

          // For every line we had to break, shift the next role down
          // to keep everything aligned
          echo str_repeat('<br>', $count);
        endforeach;
        ?>
    </div>

    <div class="film-honors">
      <h3>Honors</h3>
      <?= $film->honors; ?>
      <span></span>
    </div>

    <div class="film-staff-ratings">
      <h3>Staff Ratings</h3>
      <?php
        foreach ($film->staff_ratings as $sr):
          echo "<div class=\"{$sr->class}\">
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
    foreach ($film->reviews as $review): ?>
    <blockquote>
      <strong><?= $review->user_name; ?></strong>
      <p><?= convert_bb_code($review->comments); ?></p>
    </blockquote>
    <?php endforeach; ?>
  </section>
</main>

<?php require 'partials/footer.php'; ?>
</body>
</html>
