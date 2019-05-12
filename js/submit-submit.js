"use strict";

var qBtnSubmit = document.querySelector("form .buttons button[type='button']");

qBtnSubmit.addEventListener("click", function() {
  // Collect the form data on submit
  var fd = new FormData(qForm);

  // Convert the data to JSON
  var json = {};
  for (var field of fd) {
    json[field[0]] = field[1];
  }
  json = JSON.stringify(json);

  // Submit the data to the server for processing
  fetch("_ajax-submit.php", {
    method: "post",
    body: json
  })
  .then(function(r) { return r.json(); })
  .then(function(r) {
    console.log(r);
  });
});
