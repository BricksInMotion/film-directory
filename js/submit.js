"use strict";

var qContentWarningVio = document.querySelector("#film-vio-rate");
var qContentWarningLang = document.querySelector("#film-lang-rate");
var qContentWarningSex = document.querySelector("#film-sex-rate");

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

// Reset the sliders on page load
qContentWarningVio.value = "0";
qContentWarningLang.value = "0";
qContentWarningSex.value = "0";

// Handle the sliders being updated
qContentWarningVio.addEventListener("change", handleSliderChange);
qContentWarningLang.addEventListener("change", handleSliderChange);
qContentWarningSex.addEventListener("change", handleSliderChange);
