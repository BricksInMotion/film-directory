"use strict";

const qSearchQuery = document.querySelector(".search-input");
const qSearchResults = document.querySelector(".search-results");

// https://github.com/louisremi/jquery-smartresize#minimalist-standalone-version
function on_resize(c,t){onresize=function(){clearTimeout(t);t=setTimeout(c,100)};return c};

qSearchQuery.addEventListener("keyup", function() {
  on_resize(function(e) {
    // Fetch the search results
    fetch("_ajax-search.php", {
      method: "post",
      body: JSON.stringify({"query": e.value})
    })
    .then(r => r.text())
    .then(r => {
      console.log(r);
      qSearchResults.textContent = r;
    });
  }(this));
});
