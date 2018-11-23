<?php
$pageTitle = 'View Director';
require_once 'partials/head.php';
require_once 'partials/header.php';
require_once 'src/common-utils.php';
require_once 'src/classes/Director.php';


// TODO: Invalid arg check
$director_id = escapeXSS($_GET['director_id']);
$director = new Director($director_id);

// Get out of here if the director doesn't exist
if ($director->get_director_exists() === false) {
  redirect_url('404.php');
}
?>

<main>
</main>

<?php require 'partials/footer.php'; ?>
</body>
</html>
