<?php
// Database connection
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all the form fields are set
    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['signup-password']) && isset($_POST['confirm-password'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['signup-password'];
        $confirm_password = $_POST['confirm-password'];

        // Check if the username already exists in the database
        $checkUsernameQuery = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare($checkUsernameQuery);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "The username is already taken. Please choose another one.";
        } else {
            // Check if the email already exists
            $checkEmailQuery = "SELECT * FROM users WHERE email = :email";
            $stmt = $pdo->prepare($checkEmailQuery);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo "The email is already registered. Please try a different one.";
            } else {
                // Proceed with registration if the username and email are unique
                if ($password === $confirm_password) {
                    // Hash the password
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    // Insert the new user into the database
                    $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':password', $hashedPassword);

                    if ($stmt->execute()) {
                        // Insert profile data for the new user
                        $user_id = $pdo->lastInsertId(); // Get the user ID from the last inserted row
                        $insertProfileQuery = "INSERT INTO profiles (user_id) VALUES (:user_id)";
                        $profileStmt = $pdo->prepare($insertProfileQuery);
                        $profileStmt->bindParam(':user_id', $user_id);

                        if ($profileStmt->execute()) {
                            // Redirect to the login page after successful registration
                            header("Location: ../../index.php");
                            exit();
                        } else {
                            echo "There was an error inserting the profile data. Please try again.";
                        }
                    } else {
                        echo "There was an error during registration. Please try again.";
                    }
                } else {
                    echo "Passwords do not match. Please try again.";
                }
            }
        }
    } else {
        echo "Please fill in all fields.";
    }
}
?>
