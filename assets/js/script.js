let isLogin = true;
let tasks = [];

function toggleForm() {
    const title = document.getElementById("form-title");
    const button = document.querySelector("#form-container button");
    const toggleText = document.getElementById("toggle-form");
    const emailField = document.getElementById("email");
    const confirmPasswordField = document.getElementById("confirm-password");

    isLogin = !isLogin;

    if (isLogin) {
        title.textContent = "Login";
        button.textContent = "Login";
        toggleText.innerHTML = `Don't have an account? <span onclick="toggleForm()">Sign up</span>`;
        emailField.style.display = "none";
        confirmPasswordField.style.display = "none";
    } else {
        title.textContent = "Sign Up";
        button.textContent = "Sign up";
        toggleText.innerHTML = `Already have an account? <span onclick="toggleForm()">Login</span>`;
        emailField.style.display = "block";
        confirmPasswordField.style.display = "block";
    }
}

function authenticate() {
    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value.trim();

    if (isLogin) {
        alert("Login successful!");
        document.querySelector(".container").style.display = "none";
        document.querySelector(".dashboard-container").style.display = "flex";
        document.getElementById("search-container").style.display = "block";  // Show search bar after login
    } else {
        alert("Signup successful! You can now log in.");
        toggleForm();
    }
}

function addTask() {
    const taskInput = document.getElementById("taskInput");
    const taskText = taskInput.value.trim();

    if (taskText) {
        const task = { 
            id: Date.now(), 
            text: taskText, 
            completed: false, 
            date: new Date().toLocaleString(),  // Adding date
        };
        tasks.push(task);
        taskInput.value = '';
        renderTasks();
        updateStatistics();
    }
}

function renderTasks() {
    const taskList = document.getElementById('taskList');
    taskList.innerHTML = '';

    tasks.forEach(task => {
        const taskItem = document.createElement('li');
        taskItem.className = 'task-item' + (task.completed ? ' completed' : '');
        taskItem.innerHTML = `
            <span onclick="toggleTask(${task.id})">${task.text}</span>
            <span>(${task.date})</span>
            <button onclick="deleteTask(${task.id})">Delete</button>
            <button onclick="toggleComplete(${task.id})">${task.completed ? 'Unsubmit' : 'Complete'}</button>
            <button onclick="editTask(${task.id})">Edit</button>
        `;
        taskList.appendChild(taskItem);
    });
}

function editTask(id) {
    const task = tasks.find(t => t.id === id);
    const newText = prompt("Edit task", task.text);
    if (newText !== null && newText !== "") {
        task.text = newText;
        renderTasks();
    }
}

function toggleTask(id) {
    const task = tasks.find(t => t.id === id);
    task.completed = !task.completed;
    renderTasks();
    updateStatistics();
}

function toggleComplete(id) {
    const task = tasks.find(t => t.id === id);
    task.completed = !task.completed;  // Toggle the completed status
    renderTasks();
    updateStatistics();
}

function deleteTask(id) {
    tasks = tasks.filter(task => task.id !== id);
    renderTasks();
    updateStatistics();
}

function searchTasks() {
    const searchQuery = document.getElementById('searchInput').value.toLowerCase();
    tasks.forEach(task => {
        const taskItem = document.querySelector(`.task-item span[onclick="toggleTask(${task.id})"]`);
        if (taskItem) {
            const isVisible = task.text.toLowerCase().includes(searchQuery);
            taskItem.parentElement.style.display = isVisible ? 'flex' : 'none';
        }
    });
}

function updateStatistics() {
    const totalTasks = tasks.length;
    const completedTasks = tasks.filter(task => task.completed).length;
    const pendingTasks = totalTasks - completedTasks;

    document.getElementById("totalTasks").textContent = totalTasks;
    document.getElementById("completedTasks").textContent = completedTasks;
    document.getElementById("pendingTasks").textContent = pendingTasks;
}

function showSection(sectionId) {
    document.querySelectorAll(".content-section").forEach(section => {
        section.style.display = section.id === sectionId ? "block" : "none";
    });
}

function logout() {
    document.querySelector(".container").style.display = "flex";
    document.querySelector(".dashboard-container").style.display = "none";
}
