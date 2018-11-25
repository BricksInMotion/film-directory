<?php
$pageTitle = 'Home';
$pageStyles = ['style-index.css'];
require_once 'partials/head.php';
require_once 'partials/header.php';
require_once 'src/common-utils.php';
require_once 'src/classes/Index.php';


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
  </section>
</main>

<?php require 'partials/footer.php'; ?>
  <script src="js/index.js"></script>
</body>
</html>
