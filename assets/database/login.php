<?php
// Start the session to track user login status
session_start();

// Database connection
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Check if the username exists in the database
        $checkUserQuery = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare($checkUserQuery);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Store user_id in session after successful login
                $_SESSION['user_id'] = $user['user_id'];

                // Fetch user profile data (using the correct table name "profiles")
                $query = "SELECT * FROM profiles WHERE user_id = :user_id"; // Corrected table name
                $profileStmt = $pdo->prepare($query);
                $profileStmt->bindParam(':user_id', $_SESSION['user_id']);
                $profileStmt->execute();

                if ($profileStmt->rowCount() > 0) {
                    $profile = $profileStmt->fetch(PDO::FETCH_ASSOC);
                    // Display the profile data or redirect to the user dashboard
                    header("Location: ../../todo.php"); // Redirect to dashboard
                    exit();
                } else {
                    echo "No profile found for this user.";
                }
            } else {
                echo "Invalid username or password. Please try again.";
            }
        } else {
            echo "Invalid username or password. Please try again.";
        }
    } else {
        echo "Please enter both username and password.";
    }
}
?>
