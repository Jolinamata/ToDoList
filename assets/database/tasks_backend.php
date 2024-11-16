<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

include('config.php');

$user_id = $_SESSION['user_id'];

// Handle task completion/uncompletion
if (isset($_GET['complete']) || isset($_GET['uncomplete'])) {
    $task_id = isset($_GET['complete']) ? $_GET['complete'] : $_GET['uncomplete'];
    $completed = isset($_GET['complete']) ? 1 : 0;

    // Update task completion status
    $query = "UPDATE tasks SET completed = :completed WHERE task_id = :task_id AND user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':completed', $completed, PDO::PARAM_INT);
    $stmt->bindParam(':task_id', $task_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    header('Location: todo.php'); // Redirect to refresh the task list
    exit;
}

// Handle new task addition
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['task_text'])) {
    $task_text = $_POST['task_text'];
    $created_at = date('Y-m-d H:i:s');

    $query = "INSERT INTO tasks (user_id, task_text, created_at) VALUES (:user_id, :task_text, :created_at)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':task_text', $task_text, PDO::PARAM_STR);
    $stmt->bindParam(':created_at', $created_at, PDO::PARAM_STR);
    $stmt->execute();
    header('Location: todo.php'); // Redirect to refresh the task list
    exit;
}

// 1. LEFT JOIN: All tasks (left) and users (right)
$query_left = "SELECT users.fullname, tasks.task_id, tasks.task_text, tasks.created_at, tasks.completed 
               FROM tasks
               LEFT JOIN users ON tasks.user_id = users.user_id
               WHERE tasks.user_id = :user_id
               ORDER BY tasks.created_at DESC";

// 2. RIGHT JOIN: All users (right) and tasks (left)
$query_right = "SELECT users.fullname, tasks.task_id, tasks.task_text, tasks.created_at, tasks.completed 
                FROM tasks
                RIGHT JOIN users ON tasks.user_id = users.user_id
                WHERE tasks.user_id = :user_id
                ORDER BY tasks.created_at DESC";

// 3. INNER JOIN: Only tasks that have corresponding users
$query_inner = "SELECT users.fullname, tasks.task_id, tasks.task_text, tasks.created_at, tasks.completed 
                FROM tasks
                INNER JOIN users ON tasks.user_id = users.user_id
                WHERE tasks.user_id = :user_id
                ORDER BY tasks.created_at DESC";

// 4. FULL OUTER JOIN Simulation: Using LEFT JOIN + RIGHT JOIN with UNION
$query_outer = "(
                    SELECT users.fullname, tasks.task_id, tasks.task_text, tasks.created_at, tasks.completed 
                    FROM tasks
                    LEFT JOIN users ON tasks.user_id = users.user_id
                    WHERE tasks.user_id = :user_id
                )
                UNION
                (
                    SELECT users.fullname, tasks.task_id, tasks.task_text, tasks.created_at, tasks.completed 
                    FROM tasks
                    RIGHT JOIN users ON tasks.user_id = users.user_id
                    WHERE tasks.user_id = :user_id
                )
                ORDER BY created_at DESC";

$stmt_left = $pdo->prepare($query_left);
$stmt_right = $pdo->prepare($query_right);
$stmt_inner = $pdo->prepare($query_inner);
$stmt_outer = $pdo->prepare($query_outer);

$stmt_left->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_right->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_inner->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_outer->bindParam(':user_id', $user_id, PDO::PARAM_INT);

$stmt_left->execute();
$stmt_right->execute();
$stmt_inner->execute();
$stmt_outer->execute();

$tasks_left = $stmt_left->fetchAll(PDO::FETCH_ASSOC);
$tasks_right = $stmt_right->fetchAll(PDO::FETCH_ASSOC);
$tasks_inner = $stmt_inner->fetchAll(PDO::FETCH_ASSOC);
$tasks_outer = $stmt_outer->fetchAll(PDO::FETCH_ASSOC);

// You can choose which result set to display
// For example, to display the results of the LEFT JOIN, you would use:
$tasks = $tasks_left; // Use $tasks_right, $tasks_inner, or $tasks_outer as needed
?>
