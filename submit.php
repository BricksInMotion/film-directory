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
        <input type="text" name="film-runtime" id="film-runtime" placeholder="hh:mm:ss" pattern="^(?:\d{1,2}:)?\d{1,2}:\d{2}$">

        <label for="film-release-date">Release date</label>
        <input type="date" name="film-release-date" id="film-release-date">

        <label for="film-desc">Description</label>
        <textarea name="film-desc" id="film-desc" cols="30" rows="10"
                  placeholder="Congratulations. You've reached what you've been looking for. True joy, happiness, and personal enlightenment. The meaning of life.">
        </textarea>

        <label for="film-genre">Genres</label>
        <select name="film-genre" id="film-genre">
          <option value="action-adventure">Action/Adventure</option>
          <option value="comedy">Comedy</option>
          <option value="drama">Drama</option>
          <option value="experimental">Experimental</option>
          <option value="fantasy">Fantasy</option>
          <option value="horror">Horror</option>
          <option value="non-fiction">Non-fiction</option>
          <option value="sci-fi">Sci-fi</option>
        </select>

        <label><input type="checkbox" name="film-is-ip"> Is IP film?</label>
      </fieldset>

      <fieldset class="film-links">
        <legend>Links</legend>
        <button type="button" id="btn-add-film-link">Add link</button>
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

      <fieldset class="film-cast-crew">
        <legend>Cast &amp; Crew</legend>
        <button type="button" id="btn-add-crew-member">Add crew member</button>

        <!-- <div class="crew-member-wrapper member-1">
          <label for="crew-role-1">Role</label>
          <select name="crew-role-1" id="crew-role" class="crew-role member-1">
            <option value="director">Director</option>
            <option value="animator">Animator</option>
            <option value="voice">Voice Actor</option>
            <option value="writer">Writer</option>
            <option value="editor">Editor</option>
            <option value="composer">Composer</option>
            <option value="sound">Sound Editing</option>
            <option value="vfx">VFX Artist</option>
            <option value="other">Other Crew</option>
            <option value="thanks">Special Thanks</option>
          </select>
          <label for="crew-username">Username &nbsp;<input type="text" name="crew-username" id="crew-username"  placeholder="Username"></label>
          <label for="crew-title" class="crew-title member-1 hidden">Title &nbsp;<input type="text" name="crew-title-1" id="crew-title" placeholder="Title"></label>
          <label><input type="checkbox" name="crew-is-bim-1"> Is BiM member?</label>
          <button type="button">Remove crew member</button>
        </div> -->
        <!-- onclick="removeCrewMember(|member-id|);" -->
      </fieldset>
    </div>

    <div class="buttons">
      <button type="reset">Clear film</button>
      <button type="submit">Submit film</button>
    </div>
  </form>
</main>

<?php require 'partials/footer.php'; ?>
<script src="js/submit-add-link.js"></script>
<script src="js/submit-cast-crew.js"></script>
<script src="js/submit.js"></script>
</body>
</html>
