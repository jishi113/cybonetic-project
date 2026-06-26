// CALCULATOR - WEEK 3 DAY 3

const state = {
  display: "0",
  firstOperand: null,
  operator: null,
  waitingForSecond: false,
  history: [],
  maxHistory: 5,
};

const display = document.querySelector("#display");
const historyList = document.querySelector("#historyList");

const updateDisplay = () => {
  // Limit display to 10 significant digits
  let value = state.display;
  if (value.length > 12) {
    value = parseFloat(value).toExponential(6);
  }
  display.textContent = value;
};

const calculate = (a, b, op) => {
  switch (op) {
    case "+":
      return a + b;
    case "-":
      return a - b;
    case "*":
      return a * b;
    case "/":
      return b === 0 ? "Error" : a / b;
    default:
      return b;
  }
};

const addHistory = (expression, result) => {
  state.history.unshift({ expression, result });
  if (state.history.length > state.maxHistory) {
    state.history.pop();
  }
  renderHistory();
};

const renderHistory = () => {
  historyList.innerHTML = "";
  state.history.forEach((item) => {
    const li = document.createElement("li");
    li.textContent = `${item.expression} = ${item.result}`;
    historyList.appendChild(li);
  });
};

const inputDigit = (digit) => {
  if (state.waitingForSecond) {
    state.display = digit;
    state.waitingForSecond = false;
  } else {
    if (state.display === "0" && digit !== ".") {
      state.display = digit;
    } else if (digit === "." && state.display.includes(".")) {
      return;
    } else {
      state.display = state.display + digit;
    }
  }
  updateDisplay();
};

const inputOperator = (op) => {
  const current = parseFloat(state.display);
  if (state.firstOperand !== null && !state.waitingForSecond) {
    const result = calculate(state.firstOperand, current, state.operator);
    const expression = `${state.firstOperand} ${state.operator} ${current}`;
    state.display = String(result);
    addHistory(expression, result);
    state.firstOperand = result;
  } else {
    state.firstOperand = current;
  }
  state.operator = op;
  state.waitingForSecond = true;
  updateDisplay();
};

const handleEquals = () => {
  if (state.operator && state.firstOperand !== null) {
    const current = parseFloat(state.display);
    const expression = `${state.firstOperand} ${state.operator} ${current}`;
    const result = calculate(state.firstOperand, current, state.operator);
    state.display = String(result);
    addHistory(expression, result);
    state.firstOperand = null;
    state.operator = null;
    state.waitingForSecond = false;
    updateDisplay();
  }
};

const handleClear = () => {
  state.display = "0";
  state.firstOperand = null;
  state.operator = null;
  state.waitingForSecond = false;
  updateDisplay();
};

const handleSign = () => {
  state.display = String(parseFloat(state.display) * -1);
  updateDisplay();
};

const handlePercent = () => {
  state.display = String(parseFloat(state.display) / 100);
  updateDisplay();
};

document.querySelector(".keypad").addEventListener("click", (e) => {
  const btn = e.target.closest("button");
  if (!btn) return;

  const { action, value } = btn.dataset;

  // Clear
  if (action === "clear") {
    handleClear();
    return;
  }

  // Equals
  if (action === "equals") {
    handleEquals();
    return;
  }

  // Sign
  if (action === "sign") {
    handleSign();
    return;
  }

  // Percent
  if (action === "percent") {
    handlePercent();
    return;
  }

  // Decimal point
  if (value === ".") {
    inputDigit(".");
    return;
  }

  // Operator
  if (["+", "-", "*", "/"].includes(value)) {
    inputOperator(value);
    return;
  }

  // Number
  if (value) {
    inputDigit(value);
  }
});

document.addEventListener("keydown", (e) => {
  // Map keys to actions
  const keyMap = {
    Enter: "equals",
    Backspace: "clear",
    Escape: "clear",
    Delete: "clear",
  };

  const mapped = keyMap[e.key];
  if (mapped) {
    e.preventDefault();
    const btn = document.querySelector(`[data-action="${mapped}"]`);
    if (btn) btn.click();
    return;
  }

  // Handle operators
  const opMap = {
    "+": "+",
    "-": "-",
    "*": "*",
    "/": "/",
    "÷": "/",
    "×": "*",
  };

  if (opMap[e.key]) {
    e.preventDefault();
    const btn = document.querySelector(`[data-value="${opMap[e.key]}"]`);
    if (btn) btn.click();
    return;
  }

  // Handle numbers and decimal
  if (/^[0-9.]$/.test(e.key)) {
    const btn = document.querySelector(`[data-value="${e.key}"]`);
    if (btn) btn.click();
  }

  // Handle percent
  if (e.key === "%") {
    const btn = document.querySelector(`[data-action="percent"]`);
    if (btn) btn.click();
  }
});

console.log;
updateDisplay();
