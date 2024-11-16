<?php
// Include database connection
include('assets/database/config.php');
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <aside class="sidebar">
            <h2>Dashboard</h2>
            <ul>
                <li onclick="showSection('tasks')">To-Do List</li>
                <li onclick="showSection('stats')">Statistics</li>
                <li onclick="showSection('settings')">Settings</li>
            </ul>
            <form method="POST" action="index.php">
                <button type="submit" class="logout-button">Logout</button>
            </form>
        </aside>
        
        <main class="main-content">
            <!-- Search Bar -->
            <div class="search-container" id="search-container">
                <input type="text" id="searchInput" placeholder="Search tasks..." oninput="searchTasks()">
            </div>

            <!-- To-Do List Section -->
            <section id="tasks" class="content-section">
                <h2>To-Do List</h2>
                <div id="task-form">
                    <input type="text" id="taskInput" placeholder="Add a new task">
                    <button onclick="addTask()">Add Task</button>
                </div>
                <ul id="taskList"></ul>
            </section>

            <!-- Statistics Section -->
            <section id="stats" class="content-section" style="display: none;">
                <h2>Statistics</h2>
                <p>Total Tasks: <span id="totalTasks">0</span></p>
                <p>Completed Tasks: <span id="completedTasks">0</span></p>
                <p>Pending Tasks: <span id="pendingTasks">0</span></p>
            </section>

            <!-- Settings Section -->
            <section id="settings" class="content-section" style="display: none;">
                <h2>Settings</h2>
                <p>Settings content can be added here.</p>
            </section>
        </main>
    </div>

    <script src="assets/js/todo.js"></script>
</body>
</html>
