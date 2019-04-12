"use strict";

var crewCount = 1;


function addCastCrew() {

  // Remove the remove button if this is the first crew member.
  // A submitted film must have at least one crew member who worked on it
  if (crewCount === 1) {
    // html = html.replace(/<button.+/, "");
  }


}

function removeCastCrew() {

}

// Listen for changes in this role
var qCrewMemberRole = document.querySelector(`.crew-role.member-${crewCount}`);
var qCrewMemberTitle = document.querySelector(`.crew-title-${crewCount}`);

qCrewMemberRole.addEventListener("change", function() {
  // Show/hide the title field if we need to show it
  qCrewMemberTitle.classList.toggle(
    "hidden",
    !["other", "voice"].includes(this.value)
  );
});
