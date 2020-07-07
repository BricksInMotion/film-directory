<?php
require_once 'src/common-utils.php';
require_once 'src/classes/Api.php';


// Fetch the director info
$qs_data = [
  'id' => escape_xss($_GET['id']),
  'roles' =>'all'
];
$request = Api::get(Api::make_url('director', $qs_data));

// Handle requesting a non-existant director ID
if ($request->ok) {
  $director = load_json($request->response);
} else {
  redirect_url('404.php');
}

// Get/set director/set page info
$pageTitle = "Director {$director->info->real_name}";
$pageStyles = ['style-director.css'];

// Start loading the page
require_once 'partials/head.php';
require_once 'partials/header.php';
?>

<main>
  <?php require 'partials/navi.html'; ?>

  <section class="dir-info">
    <h2>
      <?= $director->info->real_name; ?> <small>(<?= $director->info->user_name; ?>)</small><br>
      Filmography
    </h2>
  </section>

  <div class="half">
    <section class="role-director">
      <?php $word = count($director->director) !== 1 ? 'films' : 'film'; ?>
      <h3>Director <small>(<?= count($director->director); ?> <?= $word; ?>)</small></h3>
      <?= render_film_list($director->director); ?>
    </section>

    <section class="role-voice">
      <?php $word = count($director->va) !== 1 ? 'films' : 'film'; ?>
      <h3>Voice Actor <small>(<?= count($director->va); ?> <?= $word; ?>)</small></h3>
      <?= render_film_list($director->va); ?>
    </section>
  </div>

  <div class="half">
    <section class="role-writer">
      <?php $word = count($director->writer) !== 1 ? 'films' : 'film'; ?>
      <h3>Writer <small>(<?= count($director->writer); ?> <?= $word; ?>)</small></h3>
      <?= render_film_list($director->writer); ?>
    </section>

    <section class="role-animator">
      <?php $word = count($director->animator) !== 1 ? 'films' : 'film'; ?>
      <h3>Animator <small>(<?= count($director->animator); ?> <?= $word; ?>)</small></h3>
      <?= render_film_list($director->animator); ?>
    </section>
  </div>

  <div class="half">
    <section class="role-composer">
      <?php $word = count($director->composer) !== 1 ? 'films' : 'film'; ?>
      <h3>Composer <small>(<?= count($director->composer); ?> <?= $word; ?>)</small></h3>
      <?= render_film_list($director->composer); ?>
    </section>

    <section class="role-sound">
      <?php $word = count($director->sound) !== 1 ? 'films' : 'film'; ?>
      <h3>Sound Editing <small>(<?= count($director->sound); ?> <?= $word; ?>)</small></h3>
      <?= render_film_list($director->sound); ?>
    </section>
  </div>

  <div class="half">
    <section class="role-vfx">
      <?php $word = count($director->vfx) !== 1 ? 'films' : 'film'; ?>
      <h3>Visual Effects <small>(<?=count($director->vfx); ?> <?= $word; ?>)</small></h3>
      <?= render_film_list($director->vfx); ?>
    </section>

    <section class="role-editor">
      <?php $word = count($director->editor) !== 1 ? 'films' : 'film'; ?>
      <h3>Editor <small>(<?= count($director->editor); ?> <?= $word; ?>)</small></h3>
      <?= render_film_list($director->editor); ?>
    </section>
  </div>

  <div class="half">
    <section class="role-crew">
      <?php $word = count($director->other) !== 1 ? 'films' : 'film'; ?>
      <h3>Crew <small>(<?= count($director->other); ?> <?= $word; ?>)</small></h3>
      <?= render_film_list($director->other); ?>
    </section>

    <section class="role-thanks">
      <?php $word = count($director->thanks) !== 1 ? 'films' : 'film'; ?>
      <h3>Special Thanks <small>(<?= count($director->thanks); ?> <?= $word; ?>)</small></h3>
      <?= render_film_list($director->thanks); ?>
    </section>
  </div>
</main>

<?php require 'partials/footer.php'; ?>
</body>
</html>
