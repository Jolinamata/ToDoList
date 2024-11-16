<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List - Login/Register</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <div id="form-container">
            <!-- Login Form Container -->
            <div class="form-wrapper" id="login-form-container" style="display: block;">
                <h2 id="form-title">Login</h2>
                <form id="login-form" action="assets/database/login.php" method="POST">
                    <input type="text" id="username" name="username" placeholder="Username" required>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <button type="submit">Login</button>
                </form>
            </div>

            <p id="toggle-form">Don't have an account? <span onclick="toggleForm()">Sign up</span></p>

            <!-- Registration Form Container -->
            <div class="form-wrapper" id="signup-form-container" style="display: none;">
                <h2 id="form-title">Sign Up</h2>
                <form id="signup-form" action="assets/database/register.php" method="POST">
                    <input type="text" id="username" name="username" placeholder="Username" required>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                    <input type="password" id="signup-password" name="signup-password" placeholder="Password" required>
                    <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password" required>
                    <button type="submit">Sign up</button>
                </form>
            </div>
        </div>
    </div>

    <script src="assets/js/login.js"></script>
</body>
</html>
