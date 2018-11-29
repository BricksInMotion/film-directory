"use strict";

var qAreaYears = document.querySelector(".area-filter-year");
var qFilmListYear = document.querySelector(".area-film-list h2");
var qAreaFilmList = document.querySelector(".area-film-list div");
var current_year = null;

// A year button was clicked
qAreaYears.addEventListener("click", function(e) {
  if (e.target.matches(".btn-filter-year")) {
    var year = e.target.dataset.year;

    // If the selected year is different
    // from the currently loaded year, RESET
    if (year !== current_year) {
      qFilmListYear.textContent = "Year " + year;
      qAreaFilmList.innerHTML = "";
      current_year = year;
    }

    // Fetch the next chunk of films
    fetch("_ajax-index.php", {
      method: "post",
      body: JSON.stringify({"year": year})
    })
    .then(function(r) { return r.text(); })
    .then(function(r) {
      console.log(r);
      qAreaFilmList.insertAdjacentHTML("beforeend", r);
      // qAreaFilmList.scrollIntoView({behavior: "smooth"});
      // TODO: Add infinite scroll loading
    });
  }
});
