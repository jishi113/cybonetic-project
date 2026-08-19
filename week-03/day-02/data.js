console.log("=== WEEK 3 - DAY 2: DATA MANIPULATION ===\n");

const students = [
  { name: "Jishi", score: 92, subject: "Math" },
  { name: "Priya", score: 78, subject: "Science" },
  { name: "Rahul", score: 85, subject: "English" },
  { name: "Sneha", score: 60, subject: "Math" },
  { name: "Arjun", score: 95, subject: "Science" },
  { name: "Kavya", score: 72, subject: "English" },
  { name: "Vikram", score: 88, subject: "Math" },
  { name: "Anjali", score: 55, subject: "Science" },
  { name: "Rohan", score: 81, subject: "English" },
  { name: "Meera", score: 90, subject: "Math" },
];

console.log("Student Data:");
console.log(students);

console.log("\n=== FILTER: Students scoring above 75 ===");

const topStudents = students.filter((s) => s.score >= 75);
console.log(topStudents);

console.log("\n=== MAP: Student Reports ===");

const reports = students.map((s) => `${s.name}: ${s.score}% in ${s.subject}`);
console.log(reports);

console.log("\n=== REDUCE: Class Average ===");

const totalScore = students.reduce((sum, s) => sum + s.score, 0);
const average = totalScore / students.length;
console.log(`Total Score: ${totalScore}`);
console.log(`Class Average: ${average.toFixed(2)}%`);

console.log("\n=== GROUP BY SUBJECT ===");

function groupBy(arr, key) {
  return arr.reduce((group, item) => {
    const groupKey = item[key];
    if (!group[groupKey]) {
      group[groupKey] = [];
    }
    group[groupKey].push(item);
    return group;
  }, {});
}

const groupedBySubject = groupBy(students, "subject");
console.log(groupedBySubject);

console.log("\n=== FLATTEN NESTED ARRAYS ===");

const nestedArray = [1, [2, 3], [4, [5, 6]], 7, [8, [9, [10]]]];

// Method 1: Using recursion
function flatten(arr) {
  let result = [];
  for (const item of arr) {
    if (Array.isArray(item)) {
      result = result.concat(flatten(item));
    } else {
      result.push(item);
    }
  }
  return result;
}

console.log("Nested Array:", nestedArray);
console.log("Flattened (recursion):", flatten(nestedArray));

// Method 2: Using flat(Infinity) - one line!
console.log("Flattened (flat Infinity):", nestedArray.flat(Infinity));

console.log("\n=== DESTRUCTURING: User Profile ===");

const user = {
  name: "Jishi",
  email: "jishi@example.com",
  age: 21,
  address: {
    city: "Patna",
    state: "Bihar",
    country: "India",
  },
  skills: ["HTML", "CSS", "JavaScript", "React", "Node.js"],
};

function formatProfile({
  name,
  email,
  address: { city },
  skills: [firstSkill],
}) {
  return `👤 Name: ${name}
📧 Email: ${email}
📍 City: ${city}
🔧 Primary Skill: ${firstSkill}`;
}

console.log(formatProfile(user));

console.log("\n=== SHALLOW vs DEEP COPY ===");

// Original object
const original = {
  name: "Jishi",
  age: 21,
  address: {
    city: "Patna",
    state: "Bihar",
  },
};

console.log("Original:", original);

// SHALLOW COPY using spread
const shallowCopy = { ...original };

console.log("\nShallow Copy:", shallowCopy);

// Modify nested property in shallow copy
shallowCopy.address.city = "Mumbai";
shallowCopy.name = "Jishi shah";

console.log("\nAfter modifying shallow copy:");
console.log("Shallow Copy:", shallowCopy);
console.log("Original:", original);

// The original's address.city changed too! Because address was shared.
console.log("\n❗ Both original and copy share the same address object.");
console.log("Original address.city:", original.address.city);
console.log("Copy address.city:", shallowCopy.address.city);

// DEEP COPY - Creating a true copy
console.log("\n=== DEEP COPY SOLUTION ===");

// Method 1: JSON parse/stringify (works for simple data)
function deepCopy(obj) {
  return JSON.parse(JSON.stringify(obj));
}

// Method 2: Using structuredClone (modern)
// const deepCopy = structuredClone(original);

const deepCopyObj = deepCopy(original);
deepCopyObj.address.city = "Delhi";
deepCopyObj.name = "Deep Copy";

console.log("Deep Copy:", deepCopyObj);
console.log("Original:", original);
console.log("Original's address.city is still:", original.address.city);

console.log("\n=== ARRAY METHODS DEMONSTRATION ===");

const numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

// map - transform each element
const doubled = numbers.map((n) => n * 2);
console.log("Map (double):", doubled);

// filter - keep even numbers
const evens = numbers.filter((n) => n % 2 === 0);
console.log("Filter (evens):", evens);

// reduce - sum of all numbers
const sum = numbers.reduce((acc, n) => acc + n, 0);
console.log("Reduce (sum):", sum);

// find - first number greater than 5
const found = numbers.find((n) => n > 5);
console.log("Find (>5):", found);

// some - any number greater than 10?
const hasLarge = numbers.some((n) => n > 10);
console.log("Some (>10):", hasLarge);

// every - all numbers less than 20?
const allSmall = numbers.every((n) => n < 20);
console.log("Every (<20):", allSmall);

// includes - check if 5 exists
const hasFive = numbers.includes(5);
console.log("Includes (5):", hasFive);

console.log("\n=== MORE DESTRUCTURING EXAMPLES ===");

// Array destructuring
const colors = ["red", "green", "blue", "yellow"];
const [first, second, ...restColors] = colors;
console.log("First:", first);
console.log("Second:", second);
console.log("Rest:", restColors);

// Skip elements
const [, , thirdColor] = colors;
console.log("Third (skipped first two):", thirdColor);

// Object destructuring with renaming
const { name: userName, email: userEmail, age: userAge } = user;
console.log("User name:", userName);
console.log("User email:", userEmail);
console.log("User age:", userAge);

// Default values in destructuring
const { phone = "No phone provided" } = user;
console.log("Phone:", phone);

console.log("\n=== SPREAD OPERATOR EXAMPLES ===");

// Copy array
const numbersCopy = [...numbers];
console.log("Copy of numbers:", numbersCopy);

// Merge arrays
const arr1 = [1, 2, 3];
const arr2 = [4, 5, 6];
const merged = [...arr1, ...arr2];
console.log("Merged arrays:", merged);

// Spread in function call
const maxVal = Math.max(...numbers);
console.log("Maximum value:", maxVal);

// Copy object
const userCopy = { ...user };
console.log("Copy of user:", userCopy);

// Override properties
const updatedUser = { ...user, age: 22, city: "Delhi" };
console.log("Updated user:", updatedUser);

console.log("\n=== LOOPS DEMONSTRATION ===");

// for-of loop
console.log("for-of loop:");
for (const fruit of ["apple", "banana", "mango"]) {
  console.log("  -", fruit);
}

// for-of with index
console.log("\nfor-of with index:");
for (const [index, fruit] of ["apple", "banana", "mango"].entries()) {
  console.log(`  ${index}: ${fruit}`);
}

// forEach
console.log("\nforEach:");
["apple", "banana", "mango"].forEach((fruit, index) => {
  console.log(`  ${index}: ${fruit}`);
});

// for-in (for objects)
console.log("\nfor-in (object keys):");
const person = { name: "Jishi", age: 21, city: "Patna" };
for (const key in person) {
  console.log(`  ${key}: ${person[key]}`);
}

// while loop
console.log("\nwhile loop:");
let count = 0;
while (count < 5) {
  console.log(`  Count: ${count}`);
  count++;
}

// do-while loop
console.log("\ndo-while loop:");
let num = 0;
do {
  console.log(`  Num: ${num}`);
  num++;
} while (num < 3);

// break and continue
console.log("\nbreak and continue:");
for (const n of [1, 2, 3, 4, 5, 6]) {
  if (n === 3) continue; // skip 3
  if (n === 5) break; // stop at 5
  console.log(`  ${n}`);
}

console.log("\n=== OPTIONAL CHAINING & NULLISH COALESCING ===");

// Optional chaining (?.)
const personWithAddress = {
  name: "Jishi",
  address: {
    city: "Patna",
    zip: 800001,
  },
};

const personWithoutAddress = {
  name: "Priya",
};

console.log("Person with address city:", personWithAddress?.address?.city);
console.log("Person with address zip:", personWithAddress?.address?.zip);
console.log(
  "Person without address city:",
  personWithoutAddress?.address?.city,
);
console.log("Person without address zip:", personWithoutAddress?.address?.zip);

// Nullish coalescing (??)
const name = personWithoutAddress.name ?? "Unknown";
const city = personWithoutAddress.address?.city ?? "No city provided";
console.log("Name:", name);
console.log("City:", city);

// Difference between || and ??
console.log("\n|| vs ?? comparison:");
console.log("0 || 10:", 0 || 10); // 10
console.log("0 ?? 10:", 0 ?? 10); // 0
console.log('"" || "default":', "" || "default"); // "default"
console.log('"" ?? "default":', "" ?? "default"); // ""
console.log("null || 10:", null || 10); // 10
console.log("null ?? 10:", null ?? 10); // 10

console.log;
