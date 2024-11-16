let tasks = [];

// Add a task
function addTask() {
    const taskInput = document.getElementById("taskInput");
    const taskText = taskInput.value.trim();

    if (taskText) {
        // Send the new task to the backend via POST
        fetch('list.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                task_text: taskText
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                taskInput.value = '';  // Clear input field
                loadTasks();  // Reload tasks after successful addition
            } else {
                alert("Failed to add task.");
            }
        })
        .catch(error => console.error('Error:', error));
    } else {
        alert("Task cannot be empty.");
    }
}

// Fetch tasks from the database and render them
function loadTasks() {
    fetch('list.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                tasks = data.tasks;  // Update the task list with the fetched data
                renderTasks();  // Render tasks
                updateStatistics();  // Update statistics
                updateDashboard();  // Update dashboard
            }
        })
        .catch(error => console.error('Error:', error));
}

// Render tasks in the to-do list
function renderTasks() {
    const taskList = document.getElementById('taskList');
    taskList.innerHTML = '';  // Clear the task list before rendering

    tasks.forEach(task => {
        const taskItem = document.createElement('li');
        taskItem.className = 'task-item' + (task.completed ? ' completed' : '');

        taskItem.innerHTML = `
            <span onclick="toggleComplete(${task.task_id})">${task.task_text}</span>
            <span> (${task.created_at})</span>
            ${task.completed ? 
                `<button onclick="unsubmitTask(${task.task_id})">Unsubmit</button>` :
                `<button onclick="completeTask(${task.task_id})">Complete</button>`
            }
            <button onclick="editTask(${task.task_id})">Edit</button>
            <button onclick="deleteTask(${task.task_id})">Delete</button>
        `;
        
        taskList.appendChild(taskItem);
    });
}

// Toggle task completion
function toggleComplete(id) {
    const task = tasks.find(task => task.task_id === id);
    if (task) {
        task.completed = !task.completed;  // Toggle completion status
        updateTaskStatus(id, task.completed);  // Update task in the database
    }
}

// Mark task as completed
function completeTask(id) {
    const task = tasks.find(task => task.task_id === id);
    if (task) {
        task.completed = true;  // Mark as completed
        updateTaskStatus(id, true);  // Update task in the database
    }
}

// Mark task as unsubmitted
function unsubmitTask(id) {
    const task = tasks.find(task => task.task_id === id);
    if (task) {
        task.completed = false;  // Revert task to pending
        updateTaskStatus(id, false);  // Update task in the database
    }
}

// Update task status (completion) in the database
function updateTaskStatus(id, status) {
    fetch('list.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            task_id: id,
            completed: status
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadTasks();  // Reload tasks after status update
        } else {
            alert("Failed to update task status.");
        }
    })
    .catch(error => console.error('Error:', error));
}

// Edit Task
function editTask(id) {
    const task = tasks.find(task => task.task_id === id);
    if (task) {
        const newText = prompt("Edit your task:", task.task_text);
        if (newText) {
            task.task_text = newText;
            updateTaskText(id, newText);  // Update the task text in the database
        }
    }
}

// Update task text
function updateTaskText(id, newText) {
    fetch('list.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            task_id: id,
            task_text: newText
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadTasks();  // Reload tasks after text update
        } else {
            alert("Failed to update task text.");
        }
    })
    .catch(error => console.error('Error:', error));
}

// Delete task
function deleteTask(id) {
    fetch('list.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            task_id: id
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadTasks();  // Reload tasks after deletion
        } else {
            alert("Failed to delete task.");
        }
    })
    .catch(error => console.error('Error:', error));
}

// Show section (To-Do List, Stats, Dashboard)
function showSection(section) {
    const sections = document.querySelectorAll('.content-section');
    sections.forEach(sec => sec.style.display = 'none'); // Hide all sections

    const activeSection = document.getElementById(section);
    if (activeSection) {
        activeSection.style.display = 'block';
    } else {
        console.error(`Section ${section} not found!`);
    }
}

// Load tasks when the page loads
document.addEventListener('DOMContentLoaded', () => {
    loadTasks();
});
