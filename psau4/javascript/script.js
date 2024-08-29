//Javascript for login page (three forms in one page)

// Get the link for "Forgot Password?", back button, and show third form button
const forgotLink = document.getElementById("forgot-link");
const backButton2f = document.getElementById("back-btn-2f");
const backButton3f = document.getElementById("back-btn-3f");
const showThirdFormButton = document.getElementById("show-third-form");

// Get the first, second, and third forms
const firstForm = document.querySelector(".first-form");
const secondForm = document.querySelector(".second-form");
const thirdForm = document.querySelector(".third-form");

// Add event listener to the "Forgot Password?" link
forgotLink.addEventListener("click", function (event) {
  // Prevent the default link behavior
  event.preventDefault();

  // Hide the first form
  firstForm.style.display = "none";

  // Show the second form
  secondForm.style.display = "block";
});

// Add event listener to the back button
backButton2f.addEventListener("click", function (event) {
  // Hide the second form
  secondForm.style.display = "none";

  // Show the first form
  firstForm.style.display = "block";
});

// Add event listener to the show third form button
showThirdFormButton.addEventListener("click", function (event) {
  // Hide the first form
  firstForm.style.display = "none";

  // Show the third form
  thirdForm.style.display = "block";
});

backButton3f.addEventListener("click", function (event) {
  // Hide the third form
  thirdForm.style.display = "none";

  // Show the first form
  firstForm.style.display = "block";
});
