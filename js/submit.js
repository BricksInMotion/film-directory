"use strict";

var qForm = document.querySelector("form");
var qContentWarningVio = document.querySelector("#film-vio-rate");
var qContentWarningLang = document.querySelector("#film-lang-rate");
var qContentWarningSex = document.querySelector("#film-sex-rate");
var qBasicInfoReleaseDate = document.querySelector("#film-release-date");

var warningValues = ["None", "Mild", "Moderate", "Strong"];
var warningLabels = {
  "film-vio-rate": document.querySelector(".rating-level.vio"),
  "film-lang-rate": document.querySelector(".rating-level.lang"),
  "film-sex-rate": document.querySelector(".rating-level.sex")
};


/**
 * Display the proper content warning label.
 *
 * @param {Object} e - Event object.
 */
function handleSliderChange(e) {
  warningLabels[e.target.id].textContent = warningValues[Number.parseInt(e.target.value)];
}

/**
 * Reset the content warning sliders.
 */
function resetSliderValues() {
  qContentWarningVio.value = "0";
  qContentWarningLang.value = "0";
  qContentWarningSex.value = "0";

  // Trigger the change event to update the labels
  var event = new Event("change");
  qContentWarningVio.dispatchEvent(event);
  qContentWarningLang.dispatchEvent(event);
  qContentWarningSex.dispatchEvent(event);
}

/**
 * Default the release date to today.
 */
function defaultReleaseDate() {
  var curDate = new Date();
  qBasicInfoReleaseDate.value = `${curDate.getFullYear()}-${curDate.getMonth() + 1}-${curDate.getDate()}`;
}

// Handle the sliders being updated
qContentWarningVio.addEventListener("change", handleSliderChange);
qContentWarningLang.addEventListener("change", handleSliderChange);
qContentWarningSex.addEventListener("change", handleSliderChange);


// Reset the form's custom elements
qForm.addEventListener("reset", function() {
  // https://stackoverflow.com/a/21641295
  setTimeout(function() {
    defaultReleaseDate();
    resetSliderValues();
  });
});

// Set default form values on page load
document.addEventListener("DOMContentLoaded", function() {
  addFilmLink();
  addCrewMember();
  defaultReleaseDate();
  resetSliderValues();
}, {once: true});
