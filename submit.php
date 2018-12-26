<?php
$pageTitle = 'Submit';
$pageStyles = ['style-submit.css'];
require_once 'partials/head.php';
require_once 'partials/header.php';
?>

<main>
  <?php require 'partials/navi.html'; ?>

  <section>
    <h2>Submit a film</h2>
    <p>Have a brickfilm you would like to submit to the Bricks in Motion directory? Just fill out the following fields to get started!</p>

    <p><strong>Take note!</strong> You will need to be signed into the forum for this to work! When you submit a film, you will be forwarded to the forum to post the film. If you are not already signed in, you will be prompted to sign in and may lose all your film info!</p>
  </section>


  <form autocomplete="on" method="POST" action="#">
    <div class="half">
      <fieldset>
        <legend>Basic information</legend>
        <label for="film-title">Title</label>
        <input type="text" name="film-title" id="film-title" placeholder="The Citizen of the Year">

        <label for="film-runtime">Runtime</label>
        <input type="text" name="film-runtime" id="film-runtime" placeholder="mm:ss" pattern="^(?:\d{1,2}:)?\d{2}:\d{2}$">

        <label for="film-release-date">Release date</label>
        <input type="date" name="film-release-date" id="film-release-date">

        <label for="film-desc">Description</label>
        <textarea name="film-desc" id="film-desc" cols="30" rows="10" placeholder="Congratulations. You've reached what you've been looking for. True joy, happiness, and personal enlightenment. The meaning of life."></textarea>
      </fieldset>

      <fieldset>
        <legend>Links</legend>
        <label for="film-label-1">Website</label>
        <select name="film-label-1" id="film-label-1">
          <option value="youtube" selected>YouTube</option>
          <option value="vimeo">Vimeo</option>
          <option value="google">Google Drive</option>
          <option value="other">Other</option>
        </select>
        <!-- <input type="text" name="film-label-1" id="film-label-1" placeholder="YouTube"> -->
        <label for="film-url-1">URL</label>
        <input type="url" name="film-url-1" id="film-url-1" placeholder="https://www.youtube.com/watch?v=Ajrtmp9Fc1k">
        <button type="button">Add another</button>
      </fieldset>
    </div>

    <div class="half">
      <fieldset>
        <legend>Content warnings</legend>
        <label for="film-vio-rate">Violence <span class="rating-level vio">None</span></label>
        <input type="range" name="film-vio-rate" id="film-vio-rate" min="0" max="3" value="0">

        <label for="film-lang-rate">Language <span class="rating-level lang">None</span></label>
        <input type="range" name="film-lang-rate" id="film-lang-rate" min="0" max="3" value="0">

        <label for="film-sex-rate">Sexual Content <span class="rating-level sex">None</span></label>
        <input type="range" name="film-sex-rate" id="film-sex-rate" min="0" max="3" value="0">
      </fieldset>

      <fieldset>
        <legend>Cast &amp; Crew</legend>
      </fieldset>
    </div>

    <div class="buttons">
      <button type="reset">Clear film</button>
      <button type="submit">Submit film</button>
    </div>
  </form>
</main>

<?php require 'partials/footer.php'; ?>
<script src="js/submit.js"></script>
</body>
</html>
