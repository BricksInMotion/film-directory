"use strict";

var qAreaYears = document.querySelector(".area-filter-year");
var qFilmListYear = document.querySelector(".area-film-list h2");
var qAreaFilmList = document.querySelector(".area-film-list div");
var currentYear = null;
var areFilmsVisible = false;


function isEndOfPage() {
  // Scroll threshold so users don't have to scroll
  // to the bottom of the page
  var SCROLL_THRESHOLD = 160;
  return (window.scrollY + document.body.clientHeight) >= document.body.scrollHeight - SCROLL_THRESHOLD;
}


function loadFilms(year) {
  // If the selected year is different
  // from the currently loaded year, RESET ALL THE FILMS
  if (year !== currentYear) {
    qFilmListYear.textContent = "Year " + year;
    qAreaFilmList.innerHTML = "";
    currentYear = year;
  }

  // Fetch the next chunk of films
  fetch("_ajax-index.php", {
    method: "post",
    body: JSON.stringify({"year": year})
  })
  .then(function(r) { return r.text(); })
  .then(function(r) {
    qAreaFilmList.insertAdjacentHTML("beforeend", r);
    areFilmsVisible = true;
  });
}


// Load more films
window.addEventListener("scroll", on_resize(function() {
  if (areFilmsVisible && isEndOfPage()) {
    loadFilms(currentYear);
  }
}));


qAreaYears.addEventListener("click", function(e) {
  // A film year button was clicked
  if (e.target.matches(".btn-filter-year")) {
    var year = e.target.dataset.year;

    // Only react if we are loading a different year
    if (year !== currentYear) {
      loadFilms(year);
      qAreaFilmList.scrollIntoView();
    }
  }
});
