let is24Hour = false;
let intervalId = null;

const timeEl = document.querySelector(".time");
const dateEl = document.querySelector(".date");
const secondsBar = document.querySelector(".seconds-bar");
const toggleBtn = document.querySelector(".btn-toggle");

const loadFromStorage = (key, defaultValue) => {
  try {
    const item = localStorage.getItem(key);
    return item ? JSON.parse(item) : defaultValue;
  } catch {
    return defaultValue;
  }
};

const saveToStorage = (key, data) => {
  localStorage.setItem(key, JSON.stringify(data));
};

const pad = (n) => String(n).padStart(2, "0");

const updateClock = () => {
  const now = new Date();
  const h = now.getHours();
  const m = now.getMinutes();
  const s = now.getSeconds();

  // Time display
  if (is24Hour) {
    timeEl.textContent = `${pad(h)}:${pad(m)}:${pad(s)}`;
    timeEl.removeAttribute("data-period");
  } else {
    const period = h >= 12 ? "PM" : "AM";
    const h12 = h % 12 || 12;
    timeEl.innerHTML = `${pad(h12)}:${pad(m)} <span class="seconds">:${pad(s)}</span>`;
    timeEl.dataset.period = period;
  }

  // Date display
  const days = [
    "Sunday",
    "Monday",
    "Tuesday",
    "Wednesday",
    "Thursday",
    "Friday",
    "Saturday",
  ];
  const months = [
    "Jan",
    "Feb",
    "Mar",
    "Apr",
    "May",
    "Jun",
    "Jul",
    "Aug",
    "Sep",
    "Oct",
    "Nov",
    "Dec",
  ];
  dateEl.textContent = `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;

  // Seconds progress bar
  if (secondsBar) {
    secondsBar.style.width = `${(s / 59) * 100}%`;
  }
};

toggleBtn.addEventListener("click", () => {
  is24Hour = !is24Hour;
  saveToStorage("clock_24h", is24Hour);
  toggleBtn.textContent = is24Hour ? "Switch to 12h" : "Switch to 24h";
  updateClock();
});

const startClock = () => {
  // Load saved preference
  is24Hour = loadFromStorage("clock_24h", false);
  toggleBtn.textContent = is24Hour ? "Switch to 12h" : "Switch to 24h";

  // Update immediately (no 1-second delay)
  updateClock();

  // Start interval
  intervalId = setInterval(updateClock, 1000);

  console.log("✅ Digital Clock initialized!");
};

startClock();
