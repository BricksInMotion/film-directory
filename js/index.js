"use strict";

const qAreaYears = document.querySelector(".area-filter-year");
const qFilmListYear = document.querySelector(".area-film-list h2");
const qAreaFilmList = document.querySelector(".area-film-list div");
let current_year = null;

// A year button was clicked
qAreaYears.addEventListener("click", function(e) {
  if (e.target.matches(".btn-filter-year")) {
    let year = e.target.dataset.year;

    // If the selected year is different
    // from the currently loaded year, RESET
    if (year !== current_year) {
      qFilmListYear.textContent = `Year ${year}`;
      qAreaFilmList.innerHTML = "";
      current_year = year;
    }

    // Fetch the next chunk of films
    fetch("_ajax-index.php", {
      method: "post",
      body: JSON.stringify({"year": year})
    })
    .then(r => r.text())
    .then(r => {
      console.log(r);
      qAreaFilmList.insertAdjacentHTML("beforeend", r);
      qAreaFilmList.scrollIntoView({behavior: "smooth"});
      // TODO: Add infinite scroll loading
    });
  }
});
