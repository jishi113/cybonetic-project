// ============================================================
// WEEK 3 - DAY 1: VARIABLES, TYPES & FUNCTIONS
// ============================================================

// ============================================================
// 1. TYPE COERCION EXAMPLES
// ============================================================

console.log("=== TYPE COERCION EXAMPLES ===");

// String coercion
console.log("5" + 3); // "53"
console.log("5" - 3); // 2
console.log("5" * "3"); // 15
console.log("10" / "2"); // 5

// Boolean coercion
console.log(true + 1); // 2
console.log(false + 1); // 1
console.log(true + true); // 2

// Null and undefined coercion
console.log(null + 1); // 1
console.log(undefined + 1); // NaN

// Loose equality (==) - AVOID
console.log(0 == false); // true
console.log("1" == 1); // true
console.log(null == undefined); // true

// Strict equality (===) - ALWAYS USE
console.log(0 === false); // false
console.log("1" === 1); // false
console.log(null === undefined); // false

// Falsy values
console.log(Boolean(false)); // false
console.log(Boolean(0)); // false
console.log(Boolean("")); // false
console.log(Boolean(null)); // false
console.log(Boolean(undefined)); // false
console.log(Boolean(NaN)); // false

// Truthy values
console.log(Boolean("0")); // true
console.log(Boolean([])); // true
console.log(Boolean({})); // true

// ============================================================
// 2. CALCULATOR USING CLOSURES
// ============================================================

function makeCalculator() {
  let result = 0;

  return {
    add: (num) => {
      result += num;
      return result;
    },
    subtract: (num) => {
      result -= num;
      return result;
    },
    multiply: (num) => {
      result *= num;
      return result;
    },
    divide: (num) => {
      if (num === 0) {
        throw new Error("Cannot divide by zero!");
      }
      result /= num;
      return result;
    },
    clear: () => {
      result = 0;
      return result;
    },
    getResult: () => result,
  };
}

// Test calculator
const calc = makeCalculator();
console.log("\n=== CALCULATOR TEST ===");
console.log("Add 5:", calc.add(5));
console.log("Add 3:", calc.add(3));
console.log("Subtract 2:", calc.subtract(2));
console.log("Multiply 4:", calc.multiply(4));
console.log("Divide 3:", calc.divide(3).toFixed(2));
console.log("Clear:", calc.clear());

// Test divide by zero
try {
  calc.divide(0);
} catch (error) {
  console.log("Error caught:", error.message);
}

// ============================================================
// 3. GRADE STUDENT
// ============================================================

const gradeStudent = (score) => {
  return score >= 90
    ? "A"
    : score >= 80
      ? "B"
      : score >= 70
        ? "C"
        : score >= 60
          ? "D"
          : "F";
};

console.log("\n=== GRADE STUDENT TEST ===");
console.log("Score 95:", gradeStudent(95));
console.log("Score 85:", gradeStudent(85));
console.log("Score 75:", gradeStudent(75));
console.log("Score 65:", gradeStudent(65));
console.log("Score 55:", gradeStudent(55));

// ============================================================
// 4. TEMPERATURE CONVERTERS
// ============================================================

const celsiusToFahrenheit = (c) => (c * 9) / 5 + 32;
const fahrenheitToCelsius = (f) => ((f - 32) * 5) / 9;

console.log("\n=== TEMPERATURE CONVERTER TEST ===");
console.log("0°C =", celsiusToFahrenheit(0), "°F");
console.log("100°C =", celsiusToFahrenheit(100), "°F");
console.log("32°F =", fahrenheitToCelsius(32), "°C");
console.log("212°F =", fahrenheitToCelsius(212), "°C");

// ============================================================
// 5. TEMPORAL DEAD ZONE DEMO
// ============================================================

console.log("\n=== TEMPORAL DEAD ZONE DEMO ===");

// let TDZ
try {
  console.log(letVar);
  let letVar = "Hello";
} catch (error) {
  console.log("let TDZ error:", error.message);
}

// var hoisting (no TDZ)
console.log(varVar); // undefined
var varVar = "Hello";
console.log("After declaration:", varVar);

// const TDZ
try {
  console.log(constVar);
  const constVar = "World";
} catch (error) {
  console.log("const TDZ error:", error.message);
}

console.log("\n=== EXPLANATION ===");
console.log("var: Hoisted, initialized as undefined (no TDZ)");
console.log("let/const: Hoisted but NOT initialized (TDZ exists)");
console.log("TDZ prevents accessing variables before declaration");

// ============================================================
// BONUS: DEMONSTRATE ALL DATA TYPES
// ============================================================

console.log("\n=== DATA TYPES DEMONSTRATION ===");

const stringType = "Hello";
const numberType = 42;
const booleanType = true;
const nullType = null;
const undefinedType = undefined;
const objectType = { name: "Jishi" };
const arrayType = [1, 2, 3];
const functionType = () => {};

console.log("String:", typeof stringType);
console.log("Number:", typeof numberType);
console.log("Boolean:", typeof booleanType);
console.log("Null:", typeof nullType); // "object" - historic bug!
console.log("Undefined:", typeof undefinedType);
console.log("Object:", typeof objectType);
console.log("Array:", typeof arrayType); // "object"
console.log("Array check:", Array.isArray(arrayType)); // true
console.log("Function:", typeof functionType);

console.log("\n✅ All Day 1 exercises completed!");
