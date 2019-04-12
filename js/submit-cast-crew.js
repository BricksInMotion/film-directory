"use strict";

var crewMemberCount = 0;
var qCastCrew = document.querySelector(".film-cast-crew");


function addCrewMember() {
  fetch("partials/submit-cast-crew.html")
  .then(function(r) { return r.text(); })
  .then(function(html) {
    // Keep count of the number of members we've added
    crewMemberCount++;

    // Add this member count to the loaded partial
    html = html.replace(/\|member-id\|/g, crewMemberCount.toString());

    // Remove the remove button if this is the first crew member.
    // A submitted film must have at least one crew member who worked on it
    if (crewMemberCount === 1) {
      html = html.replace(/<button.+/, "");
    }

    // Insert the partial into the page
    qCastCrew.insertAdjacentHTML("beforeend", html);

    // Listen for changes in this role
    var qCrewMemberRole = document.querySelector(`.crew-role.member-${crewMemberCount}`);
    var qCrewMemberTitle = document.querySelector(`.crew-title-${crewMemberCount}`);

    // Show/hide the title field if we need to show it
    qCrewMemberRole.addEventListener("change", function() {
      qCrewMemberTitle.classList.toggle(
        "hidden",
        !["other", "voice"].includes(this.value)
      );
    });
  })
  .catch(function(err) { console.error(err); });
}

function removeCrewMember(memberId) {
  // Decrease the link count since we're removing one
  crewMemberCount--;

  // Remove the link from the page
  document.querySelector(`.crew-member-wrapper.member-${memberId}`).remove();
}

// Load a new crew member on each button click
document.querySelector("#btn-add-crew-member").addEventListener("click", addCrewMember);

// // Listen for changes in this role
// var qCrewMemberRole = document.querySelector(`.crew-role.member-${crewCount}`);
// var qCrewMemberTitle = document.querySelector(`.crew-title-${crewCount}`);

// qCrewMemberRole.addEventListener("change", function() {
//   // Show/hide the title field if we need to show it
//   qCrewMemberTitle.classList.toggle(
//     "hidden",
//     !["other", "voice"].includes(this.value)
//   );
// });
