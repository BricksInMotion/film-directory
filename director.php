<?php
$pageTitle = 'View Director';
$pageStyles = ['style-director.css'];
require_once 'partials/head.php';
require_once 'partials/header.php';
require_once 'src/common-utils.php';
require_once 'src/classes/Director.php';


$director_id = escapeXSS($_GET['director_id']);
$director = new Director($director_id);

// Get out of here if the director doesn't exist
if ($director->get_director_exists() === false) {
  redirect_url('404.php');
}
?>

<main>
  <section class="dir-info">
    <?php $director_info = $director->get_director_info(); ?>
    <h2>Filmography for <?= $director_info->real_name; ?> <small>(<?= $director_info->user_name; ?>)</small></h2>
  </section>

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
</main>

<?php require 'partials/footer.php'; ?>
</body>
</html>
