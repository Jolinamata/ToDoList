// Toggle between Login and Sign Up forms
function toggleForm() {
    const loginForm = document.getElementById('login-form-container');
    const signupForm = document.getElementById('signup-form-container');
    const backToLogin = document.getElementById('back-to-login');
    const toggleText = document.getElementById('toggle-form'); // Link for "Don't have an account?"

    // If login form is visible, show the signup form and the back to login link
    if (loginForm.style.display === "block") {
        loginForm.style.display = "none";
        signupForm.style.display = "block";
        backToLogin.style.display = "block"; // Show "Back to Login"
        toggleText.style.display = "none"; // Hide "Don't have an account?"
    } else {
        // If signup form is visible, show the login form and the signup link
        loginForm.style.display = "block";
        signupForm.style.display = "none";
        backToLogin.style.display = "none"; // Hide "Back to Login"
        toggleText.style.display = "block"; // Show "Don't have an account?"
    }
}

// Redirect to login page after successful registration
function redirectToLogin() {
    alert('Account successfully created! Redirecting to login page...');
    setTimeout(function() {
        toggleForm(); // Switch to login form after successful signup
    }, 1500); // Wait for 1.5 seconds before switching
}

document.querySelectorAll('.input-container input').forEach(input => {
    input.addEventListener('input', function() {
        const icon = this.previousElementSibling; // Get the icon element
        if (this.value) {
            icon.style.opacity = '0'; // Hide the icon when typing
        } else {
            icon.style.opacity = '1'; // Show the icon when no text is entered
        }
    });
});
