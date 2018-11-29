"use strict";

var qSearchQuery = document.querySelector(".search-input");
var qSearchResults = document.querySelector(".search-results");

// https://davidwalsh.name/javascript-debounce-function
// Returns a function, that, as long as it continues to be invoked, will not
// be triggered. The function will be called after it stops being called for
// N milliseconds. If `immediate` is passed, trigger the function on the
// leading edge, instead of the trailing.
function debounce(func, wait, immediate) {
	var timeout;
	return function() {
		var context = this, args = arguments;
		var later = function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		};
		var callNow = immediate && !timeout;
		clearTimeout(timeout);
		timeout = setTimeout(later, wait);
		if (callNow) func.apply(context, args);
	};
};

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
