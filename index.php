<?php
$pageTitle = 'Home';
$pageStyles = ['style-index.css'];
require_once 'partials/head.php';
require_once 'partials/header.php';
require_once 'src/common-utils.php';
require_once 'src/classes/Index.php';

// Always start a new session on page reload
if (session_status() === PHP_SESSION_NONE) {
  session_start();
} else {
  $_SESSION = [];
}
$index = new Index;
?>

<!--
Display
film title
film director
film release date

Order by
film release date

Filter by
film title
-->

<main>
  <section>
   <h2>View Films</h2>
   <h3>View films by year</h3>
    <div class="area-filter-year">
  <?php
    foreach ($index::get_film_years() as $year):
      echo "<span class='btn-filter-year' data-year='{$year}'>{$year}</span>";
    endforeach;
  ?>
  </div>
  </section>

  <section class="area-film-list">
    <h2 class="film-year"></h2>
    <div></div>
  </section>
</main>

<?php require 'partials/footer.php'; ?>
<script src="js/index.js"></script>
</body>
</html>
