"use strict";

const qYearBtns = document.querySelector(".area-filter-year");

qYearBtns.addEventListener("click", function(e) {
  if (e.target.matches(".btn-filter-year")) {
    let btnClicked = e.target;

    fetch("_ajax-index.php", {
      method: "post",
      body: JSON.stringify({"year": btnClicked.dataset.year})
    })
    .then(r => r.json())
    .then(r => console.log(r));
  }
});
