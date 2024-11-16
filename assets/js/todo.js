let tasks = [];

function addTask() {
    const taskInput = document.getElementById("taskInput");
    const taskText = taskInput.value.trim();

    if (taskText) {
        const task = {
            id: Date.now(),
            text: taskText,
            completed: false,
            date: new Date().toLocaleString()
        };
        tasks.push(task);
        taskInput.value = '';
        renderTasks();
        updateStatistics();
    } else {
        alert("Task cannot be empty.");
    }
}

function renderTasks() {
    const taskList = document.getElementById('taskList');
    taskList.innerHTML = '';  // Clear the task list before rendering

    tasks.forEach(task => {
        const taskItem = document.createElement('li');
        taskItem.className = 'task-item' + (task.completed ? ' completed' : '');

        taskItem.innerHTML = `
            <span onclick="toggleComplete(${task.id})">${task.text}</span>
            <span> (${task.date})</span>
            ${task.completed ? 
                `<button onclick="unsubmitTask(${task.id})">Unsubmit</button>` :
                `<button onclick="completeTask(${task.id})">Complete</button>`
            }
            <button onclick="editTask(${task.id})">Edit</button>
            <button onclick="deleteTask(${task.id})">Delete</button>
        `;
        
        taskList.appendChild(taskItem);
    });
}

// Toggle task completion
function toggleComplete(id) {
    const task = tasks.find(task => task.id === id);
    if (task) {
        task.completed = !task.completed;  // Toggle completion status
        renderTasks();
        updateStatistics();
    }
}

// Mark task as completed
function completeTask(id) {
    const task = tasks.find(task => task.id === id);
    if (task) {
        task.completed = true;  // Mark as completed
        renderTasks();
        updateStatistics();
    }
}

// Mark task as unsubmitted
function unsubmitTask(id) {
    const task = tasks.find(task => task.id === id);
    if (task) {
        task.completed = false;  // Revert task to pending
        renderTasks();
        updateStatistics();
    }
}

// Edit Task
function editTask(id) {
    const task = tasks.find(task => task.id === id);
    if (task) {
        const newText = prompt("Edit your task:", task.text);
        if (newText) {
            task.text = newText.trim();  // Update task text
            renderTasks();
        }
    }
}

function deleteTask(id) {
    tasks = tasks.filter(task => task.id !== id);
    renderTasks();
    updateStatistics();
}

function updateStatistics() {
    const totalTasks = tasks.length;
    const completedTasks = tasks.filter(task => task.completed).length;
    const pendingTasks = totalTasks - completedTasks;

    document.getElementById("totalTasks").textContent = totalTasks;
    document.getElementById("completedTasks").textContent = completedTasks;
    document.getElementById("pendingTasks").textContent = pendingTasks;
}

function showSection(section) {
    // Hide all sections
    const sections = document.querySelectorAll('.content-section');
    sections.forEach(sec => sec.style.display = 'none');

    // Show the selected section
    document.getElementById(section).style.display = 'block';
}

function logout() {
    window.location.href = "index.html";
}
