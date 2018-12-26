<?php
require_once 'src/common-utils.php';
require_once 'src/classes/Director.php';

$director_id = escape_xss($_GET['director_id']);
$director = new Director($director_id);

// Get out of here if the director doesn't exist
if ($director->get_director_exists() === false) {
  redirect_url('404.php');
}

// Get/set director/set page info
$director_info = $director->get_director_info();
$pageTitle = "Director {$director_info->real_name}";
$pageStyles = ['style-director.css'];

// Start loading the page
require_once 'partials/head.php';
require_once 'partials/header.php';
?>

<main>
  <?php require 'partials/navi.html'; ?>

  <section class="dir-info">
    <h2>
      <?= $director_info->real_name; ?> <small>(<?= $director_info->user_name; ?>)</small><br>
      Filmography
    </h2>
  </section>

  <div class="half">
    <section class="role-director">
      <?php
        $role_director = $director->get_role_director();
        $info = array_pop($role_director);
      ?>
      <h3>Director <small>(<?= $info->total; ?> <?= $info->word; ?>)</small></h3>
      <?= render_film_list($role_director); ?>
    </section>

    <section class="role-voice">
      <?php
      $role_voice = $director->get_role_voice();
      $info = array_pop($role_voice);
      ?>
      <h3>Voice Actor <small>(<?= $info->total; ?> <?= $info->word; ?>)</small></h3>
      <?= render_film_list($role_voice); ?>
    </section>
  </div>

  <div class="half">
    <section class="role-writer">
      <?php
        $role_writer = $director->get_role_writer();
        $info = array_pop($role_writer);
      ?>
      <h3>Writer <small>(<?= $info->total; ?> <?= $info->word; ?>)</small></h3>
      <?= render_film_list($role_writer); ?>
    </section>

    <section class="role-animator">
      <?php
        $role_animator = $director->get_role_animator();
        $info = array_pop($role_animator);
      ?>
      <h3>Animator <small>(<?= $info->total; ?> <?= $info->word; ?>)</small></h3>
      <?= render_film_list($role_animator); ?>
    </section>
  </div>

  <div class="half">
    <section class="role-composer">
      <?php
        $role_composer = $director->get_role_composer();
        $info = array_pop($role_composer);
      ?>
      <h3>Composer <small>(<?= $info->total; ?> <?= $info->word; ?>)</small></h3>
      <?= render_film_list($role_composer); ?>
    </section>

    <section class="role-sound">
      <?php
        $role_sound = $director->get_role_sound();
        $info = array_pop($role_sound);
      ?>
      <h3>Sound Editing <small>(<?= $info->total; ?> <?= $info->word; ?>)</small></h3>
      <?= render_film_list($role_sound); ?>
    </section>
  </div>

  <div class="half">
    <section class="role-vfx">
      <?php
        $role_vfx = $director->get_role_vfx();
        $info = array_pop($role_vfx);
      ?>
      <h3>Visual Effects <small>(<?= $info->total; ?> <?= $info->word; ?>)</small></h3>
      <?= render_film_list($role_vfx); ?>
    </section>

    <section class="role-editor">
      <?php
        $role_editor = $director->get_role_editor();
        $info = array_pop($role_editor);
      ?>
      <h3>Editor <small>(<?= $info->total; ?> <?= $info->word; ?>)</small></h3>
      <?= render_film_list($role_editor); ?>
    </section>
  </div>

  <div class="half">
    <section class="role-crew">
      <?php
        $role_crew = $director->get_role_crew();
        $info = array_pop($role_crew);
      ?>
      <h3>Crew <small>(<?= $info->total; ?> <?= $info->word; ?>)</small></h3>
      <?= render_film_list($role_crew); ?>
    </section>

    <section class="role-thanks">
      <?php
        $role_thanks = $director->get_role_thanks();
        $info = array_pop($role_thanks);
      ?>
      <h3>Special Thanks <small>(<?= $info->total; ?> <?= $info->word; ?>)</small></h3>
      <?= render_film_list($role_thanks); ?>
    </section>
  </div>
</main>

<?php require 'partials/footer.php'; ?>
</body>
</html>
