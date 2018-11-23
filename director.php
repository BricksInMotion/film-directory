<?php
$pageTitle = 'View Director';
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
    <h2><?= $director_info->real_name; ?> <small>(<?= $director_info->user_name; ?>)</small></h2>
  </section>

  <section class="dir-filmography">
    <h2>Filmography</h2>

    <div class="role-director">
      <h3>Director <small>( films)</small></h3>
    </div>
  </section>
</main>

<?php require 'partials/footer.php'; ?>
</body>
</html>
