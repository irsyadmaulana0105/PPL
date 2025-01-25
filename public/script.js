// JavaScript to handle form validation and other interactions

// Wait until the DOM is fully loaded
document.addEventListener("DOMContentLoaded", function() {

    // Get the login form
    const loginForm = document.querySelector("form");

    // Add an event listener for form submission
    loginForm.addEventListener("submit", function(event) {
        // Get the email and password input fields
        const emailInput = document.querySelector("input[name='email']");
        const passwordInput = document.querySelector("input[name='password']");
        
        // Basic validation to check if email and password are not empty
        if (emailInput.value.trim() === "" || passwordInput.value.trim() === "") {
            // Prevent the form from being submitted
            event.preventDefault();

            // Show an alert message
            alert("Email and Password cannot be empty!");
        }
    });

    // Additional UI enhancements can be added here
    // For example, toggling password visibility
    const passwordInput = document.querySelector("input[name='password']");
    const togglePasswordVisibility = document.createElement('span');
    togglePasswordVisibility.textContent = "Show";
    togglePasswordVisibility.style.cursor = "pointer";
    togglePasswordVisibility.style.marginLeft = "10px";

    passwordInput.parentNode.appendChild(togglePasswordVisibility);

    togglePasswordVisibility.addEventListener("click", function() {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            togglePasswordVisibility.textContent = "Hide";
        } else {
            passwordInput.type = "password";
            togglePasswordVisibility.textContent = "Show";
        }
    });

});
