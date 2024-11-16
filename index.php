<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List - Login/Register</title>
    <!-- Font Awesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <div id="form-container">
            <!-- Login Form Container -->
            <div class="form-wrapper" id="login-form-container" style="display: block;">
                <h2 id="form-title">Login <i class="fas fa-user"></i></h2>
                <form id="login-form" action="assets/database/login.php" method="POST">
                    <div class="input-container">
                        <input type="text" id="username" name="username" placeholder="Username" required>
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="input-container">
                        <input type="password" id="password" name="password" placeholder="Password" required>
                        <i class="fas fa-lock"></i>
                    </div>
                    <button type="submit">Login</button>
                </form>
            </div>

            <p id="toggle-form">Don't have an account? <span onclick="toggleForm()"><i class="fas fa-user-plus"></i> Sign up</span></p>

            <!-- Registration Form Container -->
            <div class="form-wrapper" id="signup-form-container" style="display: none;">
                <h2 id="form-title">Sign Up <i class="fas fa-user-plus"></i></h2>
                <form id="signup-form" action="assets/database/register.php" method="POST">
                    <div class="input-container">
                        <input type="text" id="username" name="username" placeholder="Username" required>
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="input-container">
                        <input type="email" id="email" name="email" placeholder="Email" required>
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="input-container">
                        <input type="password" id="signup-password" name="signup-password" placeholder="Password" required>
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="input-container">
                        <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password" required>
                        <i class="fas fa-lock"></i>
                    </div>
                    <button type="submit">Sign up</button>
                </form>
            </div>

            <p id="back-to-login" style="display: none;" class="toggle-form-text">
                Already have an account? <span onclick="toggleForm()"><i class="fas fa-arrow-left"></i> Back to Login</span>
            </p>
        </div>
    </div>

    <script src="assets/js/login.js"></script>
</body>
</html>
