<?php
// Include the backend logic to fetch tasks
include('assets/database/tasks_backend.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List Dashboard</title>
    <link rel="stylesheet" href="assets/css/todo.css">
    <!-- Add FontAwesome CDN for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <h2>Dashboard</h2>
            <div class="button-group">
                <button onclick="showSection('tasks')" class="nav-button"><i class="fas fa-list"></i> To-Do List</button>
                <button onclick="showSection('stats')" class="nav-button"><i class="fas fa-chart-pie"></i> Statistics</button>
                <button onclick="showSection('Dashboard')" class="nav-button"><i class="fas fa-tachometer-alt"></i> Dashboard</button>
            </div>
            <form method="POST" action="index.php">
                <button type="submit" class="logout-button"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </aside>
        
        <main class="main-content">
            <div class="search-container" id="search-container">
                <input type="text" id="searchInput" placeholder="Search tasks...">
            </div>

            <!-- To-Do List Section -->
            <section id="tasks" class="content-section">
                <h2><i class="fas fa-tasks"></i> To-Do List</h2>
                <div id="task-form">
                    <form method="POST" action="todo.php">
                        <input type="text" name="task_text" placeholder="Add a new task" required>
                        <button type="submit"><i class="fas fa-plus"></i> Add Task</button>
                    </form>
                </div>
                <ul id="taskList">
                    <?php foreach ($tasks as $task): ?>
                        <li>
                            <?= htmlspecialchars($task['task_text']) ?> - <?= htmlspecialchars($task['created_at']) ?>
                            <form method="GET" action="todo.php" style="display:inline;">
                                <?php if (!$task['completed']): ?>
                                    <button type="submit" name="complete" value="<?= $task['task_id'] ?>"><i class="fas fa-check-circle"></i> Complete</button>
                                <?php else: ?>
                                    <button type="submit" name="uncomplete" value="<?= $task['task_id'] ?>"><i class="fas fa-times-circle"></i> Uncomplete</button>
                                <?php endif; ?>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>

            <!-- Statistics Section -->
            <section id="stats" class="content-section" style="display: none;">
                <h2><i class="fas fa-chart-pie"></i> Statistics</h2>
                <p>Total Tasks: <span id="totalTasks"><?= count($tasks) ?></span></p>
                <p>Completed Tasks: <span id="completedTasks"><?= count(array_filter($tasks, fn($task) => $task['completed'] == 1)) ?></span></p>
                <p>Pending Tasks: <span id="pendingTasks"><?= count(array_filter($tasks, fn($task) => $task['completed'] == 0)) ?></span></p>
            </section>

            <!-- Dashboard Section -->
            <section id="Dashboard" class="content-section" style="display: none;">
                <h2><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
                <h3>Total Tasks</h3>
                <table id="totalTasksTable">
                    <tr>
                        <th>Task Name</th>
                        <th>Date/Time</th>
                    </tr>
                    <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?= htmlspecialchars($task['task_text']) ?></td>
                        <td><?= htmlspecialchars($task['created_at']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>

                <h3>Completed Tasks</h3>
                <table id="completedTasksTable">
                    <tr>
                        <th>Task Name</th>
                        <th>Date/Time</th>
                    </tr>
                    <?php foreach ($tasks as $task): ?>
                        <?php if ($task['completed']): ?>
                            <tr>
                                <td><?= htmlspecialchars($task['task_text']) ?></td>
                                <td><?= htmlspecialchars($task['created_at']) ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </table>

                <h3>Pending Tasks</h3>
                <table id="pendingTasksTable">
                    <tr>
                        <th>Task Name</th>
                        <th>Date/Time</th>
                    </tr>
                    <?php foreach ($tasks as $task): ?>
                        <?php if (!$task['completed']): ?>
                            <tr>
                                <td><?= htmlspecialchars($task['task_text']) ?></td>
                                <td><?= htmlspecialchars($task['created_at']) ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </table>
            </section>
        </main>
    </div>

    <script src="assets/js/todo.js"></script>
</body>
</html>
