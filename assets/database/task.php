<?php
// Include the database connection
include('config.php');
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];  // Get the user ID from session

// Function to add a new task
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get task text from the POST request
    $task_text = trim($_POST['task_text']);
    
    if (!empty($task_text)) {
        // Prepare SQL query to insert the task
        $stmt = $pdo->prepare("INSERT INTO tasks (user_id, task_text) VALUES (:user_id, :task_text)");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':task_text', $task_text);

        if ($stmt->execute()) {
            echo json_encode(['success' => 'Task added successfully']);
        } else {
            echo json_encode(['error' => 'Failed to add task']);
        }
    } else {
        echo json_encode(['error' => 'Task cannot be empty']);
    }
}

// Function to fetch tasks from the database
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Prepare SQL query to fetch tasks for the logged-in user
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    
    // Fetch all tasks
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($tasks);  // Return tasks as JSON
}
?>
