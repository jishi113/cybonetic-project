let todos = [];
let filter = "all";
let sortBy = "date";

const todoList = document.querySelector(".todo-list");
const todoForm = document.querySelector(".todo-form");
const todoInput = document.querySelector(".todo-input");
const filterBtns = document.querySelectorAll(".filter-btn");
const clearCompletedBtn = document.querySelector(".btn-clear-completed");
const countDisplay = document.querySelector(".count");
const emptyState = document.querySelector(".empty-state");
const sortSelect = document.querySelector("#sortBy");

const uid = () =>
  `todo_${Date.now()}_${Math.random().toString(36).slice(2, 7)}`;

const loadFromStorage = (key, defaultValue = null) => {
  try {
    const item = localStorage.getItem(key);
    return item ? JSON.parse(item) : defaultValue;
  } catch (e) {
    console.error(`Failed to parse localStorage key "${key}":`, e);
    return defaultValue;
  }
};

const saveToStorage = (key, data) => {
  localStorage.setItem(key, JSON.stringify(data));
};

const addTodo = (text) => {
  if (!text.trim()) return;
  todos.push({
    id: uid(),
    text: text.trim(),
    done: false,
    createdAt: Date.now(),
  });
  saveAndRender();
};

const deleteTodo = (id) => {
  todos = todos.filter((t) => t.id !== id);
  saveAndRender();
};

const toggleTodo = (id) => {
  todos = todos.map((t) => (t.id === id ? { ...t, done: !t.done } : t));
  saveAndRender();
};

const editTodo = (id, newText) => {
  if (!newText.trim()) return;
  todos = todos.map((t) => (t.id === id ? { ...t, text: newText.trim() } : t));
  saveAndRender();
};

const clearCompleted = () => {
  todos = todos.filter((t) => !t.done);
  saveAndRender();
};

const sortTodos = (todosArray) => {
  const sorted = [...todosArray];
  switch (sortBy) {
    case "alphabetical":
      sorted.sort((a, b) => a.text.localeCompare(b.text));
      break;
    case "completed":
      sorted.sort((a, b) => Number(a.done) - Number(b.done));
      break;
    case "date":
    default:
      sorted.sort((a, b) => b.createdAt - a.createdAt);
      break;
  }
  return sorted;
};

const getFilteredTodos = () => {
  let filtered = todos;
  switch (filter) {
    case "active":
      filtered = todos.filter((t) => !t.done);
      break;
    case "completed":
      filtered = todos.filter((t) => t.done);
      break;
    default:
      break;
  }
  return sortTodos(filtered);
};

const render = () => {
  const filtered = getFilteredTodos();

  // Render list
  if (filtered.length === 0) {
    todoList.innerHTML = "";
    emptyState.style.display = "block";
  } else {
    emptyState.style.display = "none";
    todoList.innerHTML = filtered
      .map(
        (todo) => `
            <li class="todo-item ${todo.done ? "done" : ""}" data-id="${todo.id}" draggable="true">
                <button class="btn-check">${todo.done ? "✓" : ""}</button>
                <span class="todo-text">${todo.text}</span>
                <span class="todo-date" style="font-size:12px;color:#aaa;margin-right:8px;">
                    ${new Date(todo.createdAt).toLocaleDateString()}
                </span>
                <button class="btn-edit">✏️</button>
                <button class="btn-delete">✕</button>
            </li>
        `,
      )
      .join("");
  }

  // Update count
  const remaining = todos.filter((t) => !t.done).length;
  countDisplay.textContent = `${remaining} item${remaining !== 1 ? "s" : ""} left`;

  // Show/hide clear completed
  const hasCompleted = todos.some((t) => t.done);
  clearCompletedBtn.classList.toggle("hidden", !hasCompleted);

  // Update active filter button
  filterBtns.forEach((btn) => {
    btn.classList.toggle("active", btn.dataset.filter === filter);
  });

  // Save filter and sort to localStorage
  saveToStorage("todoFilter", filter);
  saveToStorage("todoSort", sortBy);
};

const saveAndRender = () => {
  saveToStorage("todos", todos);
  render();
};

let dragStartId = null;

todoList.addEventListener("dragstart", (e) => {
  const item = e.target.closest(".todo-item");
  if (!item) return;
  dragStartId = item.dataset.id;
  item.style.opacity = "0.5";
});

todoList.addEventListener("dragend", (e) => {
  const item = e.target.closest(".todo-item");
  if (item) item.style.opacity = "1";
});

todoList.addEventListener("dragover", (e) => {
  e.preventDefault();
  const item = e.target.closest(".todo-item");
  if (!item || item.dataset.id === dragStartId) return;
  item.style.borderTop = "2px solid #0055ee";
});

todoList.addEventListener("dragleave", (e) => {
  const item = e.target.closest(".todo-item");
  if (item) item.style.borderTop = "none";
});

todoList.addEventListener("drop", (e) => {
  e.preventDefault();
  const item = e.target.closest(".todo-item");
  if (!item || !dragStartId || item.dataset.id === dragStartId) {
    if (item) item.style.borderTop = "none";
    return;
  }

  const dragIndex = todos.findIndex((t) => t.id === dragStartId);
  const dropIndex = todos.findIndex((t) => t.id === item.dataset.id);

  if (dragIndex !== -1 && dropIndex !== -1) {
    const [dragged] = todos.splice(dragIndex, 1);
    todos.splice(dropIndex, 0, dragged);
    saveAndRender();
  }

  item.style.borderTop = "none";
  dragStartId = null;
});

// Form submit - Add todo
todoForm.addEventListener("submit", (e) => {
  e.preventDefault();
  addTodo(todoInput.value);
  todoInput.value = "";
  todoInput.focus();
});

// Event delegation on todo list
todoList.addEventListener("click", (e) => {
  const item = e.target.closest(".todo-item");
  if (!item) return;
  const id = item.dataset.id;

  if (e.target.closest(".btn-check")) {
    toggleTodo(id);
  } else if (e.target.closest(".btn-delete")) {
    if (confirm("Delete this task?")) deleteTodo(id);
  } else if (e.target.closest(".btn-edit")) {
    const span = item.querySelector(".todo-text");
    const newText = prompt("Edit task:", span.textContent);
    if (newText !== null) editTodo(id, newText);
  }
});

// Filter buttons
filterBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    filter = btn.dataset.filter;
    render();
  });
});

// Clear completed
clearCompletedBtn.addEventListener("click", clearCompleted);

// Sort by
sortSelect.addEventListener("change", (e) => {
  sortBy = e.target.value;
  render();
});

// Keyboard shortcut: Escape to cancel edit (handled in prompt)
document.addEventListener("keydown", (e) => {
  if (e.key === "Escape") {
    // Close any open prompt by blurring
    if (document.activeElement) {
      document.activeElement.blur();
    }
  }
});

document.addEventListener("keydown", (e) => {
  if (e.key === "Delete" || e.key === "Backspace") {
    // Check if we're in an input
    if (e.target.tagName === "INPUT") return;

    // Find highlighted todo (if any)
    const highlighted = document.querySelector(".todo-item:hover");
    if (highlighted) {
      const id = highlighted.dataset.id;
      if (confirm("Delete this task?")) deleteTodo(id);
    }
  }
});

const init = () => {
  // Load todos
  todos = loadFromStorage("todos", []);

  // Load filter
  filter = loadFromStorage("todoFilter", "all");

  // Load sort
  sortBy = loadFromStorage("todoSort", "date");
  sortSelect.value = sortBy;

  render();
  console.log("✅ To-Do App initialized!");
};

init();
