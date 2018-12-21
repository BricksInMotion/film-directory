"use strict";

var qSearchQuery = document.querySelector(".search-input");
var qSearchResults = document.querySelector(".search-results");

// Debounce the search to improve input performance
var doASearch = debounce(function() {
  // Fetch the search results
  fetch("_ajax-search.php", {
    method: "post",
    body: JSON.stringify({"query": qSearchQuery.value})
  })
  .then(function(r) { return r.text(); })
  .then(function(r) {
    qSearchResults.innerHTML = r;
  });
}, 250);

qSearchQuery.addEventListener("keyup", doASearch);
