<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Login and Signup Form -->
    <div class="container">
        <div id="form-container">
            <h2 id="form-title">Login</h2>
            <input type="text" id="username" placeholder="Username" required>
            <input type="password" id="password" placeholder="Password" required>
            <input type="email" id="email" placeholder="Email" style="display: none;" required>
            <input type="password" id="confirm-password" placeholder="Confirm Password" style="display: none;" required>
            <button onclick="authenticate()">Login</button>
            <p id="toggle-form">Don't have an account? <span onclick="toggleForm()">Sign up</span></p>
        </div>
    </div>

    <!-- Dashboard Container (Hidden by default through CSS) -->
    <div class="dashboard-container" style="display: none;">
        <aside class="sidebar">
            <h2>Dashboard</h2>
            <ul>
                <li onclick="showSection('tasks')">To-Do List</li>
                <li onclick="showSection('stats')">Statistics</li>
                <li onclick="showSection('settings')">Settings</li>
            </ul>
            <button class="logout-button" onclick="logout()">Logout</button>
        </aside>
        
        <main class="main-content">
            <!-- Search Bar (Visible after login) -->
            <div class="search-container" style="display: none;" id="search-container">
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
                <!-- Display Rating of Done Tasks -->
                <div id="rating-summary">
                    <ul id="rating-list"></ul>
                </div>
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

    <script src="assets/js/script.js"></script>
</body>
</html>
