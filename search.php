<?php
  $pageTitle = 'Search by Title';
  $pageStyles = ['style-search.css'];
  require_once 'partials/head.php';
  require_once 'partials/header.php';
?>

<main>
  <?php require 'partials/navi.html'; ?>

  <section>
    <h2>Search by film title</h2>
    <label>
      <input type="text" class="search-input" autocomplete="on" placeholder="The Citizen of the Year">
    </label>
  </section>

  <section class="search-results">
  </section>
</main>

<?php require 'partials/footer.php'; ?>
<script src="js/search.js"></script>
</body>
</html>
