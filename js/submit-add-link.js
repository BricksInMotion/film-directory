"use strict";

var filmLinkCount = 0;
var qFilmLinks = document.querySelector(".film-links");

function addFilmLink() {
  fetch("partials/submit-links.html")
  .then(function(r) { return r.text(); })
  .then(function(html) {
    // Keep count of the number of links we've added
    filmLinkCount++;

    // Add this film count to the loaded partial
    html = html.replace(/\|link-id\|/g, filmLinkCount.toString());

    // Remove the remove button if this is the first link.
    // A submitted film must have at least one link to it
    if (filmLinkCount === 1) {
      html = html.replace(/<button.+/, "");
    }

    // Insert the partial into the page
    qFilmLinks.insertAdjacentHTML("beforeend", html);
  })
  .catch(function(err) { console.error(err); });
}

function removeFilmLink(linkId) {
  // Decrease the link count since we're removing one
  filmLinkCount--;

  // Remove the link from the page
  document.querySelector(`.film-link-wrapper.link-${linkId}`).remove()
}

// Load a film link partial on each button click
document.querySelector("#btn-add-film-link").addEventListener("click", addFilmLink);
