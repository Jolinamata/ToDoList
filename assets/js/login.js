// Function to toggle between login and signup forms
function toggleForm() {
    var loginForm = document.getElementById('login-form-container');
    var signupForm = document.getElementById('signup-form-container');
    
    // Toggle the display between login and signup forms
    if (loginForm.style.display === 'block') {
        loginForm.style.display = 'none';
        signupForm.style.display = 'block';
    } else {
        loginForm.style.display = 'block';
        signupForm.style.display = 'none';
    }
}

// Redirect to login page after successful registration
function redirectToLogin() {
    alert('Account successfully created! Redirecting to login page...');
    setTimeout(function() {
        toggleForm(); // Switch to login form after successful signup
    }, 1500); // Wait for 1.5 seconds before switching
}
