const RULES = {
  name: {
    validate: (v) => v.trim().length >= 2,
    message: "Name must be at least 2 characters",
  },
  email: {
    validate: (v) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v),
    message: "Enter a valid email address",
  },
  phone: {
    validate: (v) => /^[6-9]\d{9}$/.test(v),
    message: "Enter a valid 10-digit Indian mobile number",
  },
  password: {
    validate: (v) =>
      /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/.test(v),
    message: "Min 8 chars: uppercase, lowercase, number, symbol",
  },
  username: {
    validate: (v) => /^[a-z0-9_]{3,20}$/.test(v),
    message: "3-20 chars, lowercase, numbers, underscores only",
  },
  url: {
    validate: (v) => {
      try {
        new URL(v);
        return true;
      } catch {
        return false;
      }
    },
    message: "Enter a valid URL (include https://)",
  },
  pincode: {
    validate: (v) => /^[1-9]\d{5}$/.test(v),
    message: "Enter a valid 6-digit PIN code",
  },
};

const validateField = (field) => {
  const rule = RULES[field.name];
  const value = field.value;
  const wrapper = field.closest(".field-wrapper");
  const msgEl = wrapper?.querySelector(".field-message");

  // Empty field - required error if touched
  if (!value.trim()) {
    setFieldState(
      wrapper,
      msgEl,
      "error",
      `${field.placeholder || field.name} is required`,
    );
    return false;
  }

  // No rule - always valid
  if (!rule) return true;

  if (rule.validate(value)) {
    setFieldState(wrapper, msgEl, "success", "✅ Looks good!");
    return true;
  } else {
    setFieldState(wrapper, msgEl, "error", rule.message);
    return false;
  }
};

const setFieldState = (wrapper, msgEl, state, message) => {
  wrapper?.classList.remove("state-error", "state-success");
  wrapper?.classList.add(`state-${state}`);
  if (msgEl) msgEl.textContent = message;
};

const showSuccessMessage = (message) => {
  const el = document.getElementById("successMessage");
  if (el) {
    el.textContent = `✅ ${message}`;
    el.style.display = "block";
    setTimeout(() => {
      el.style.display = "none";
    }, 3000);
  }
};

document.querySelectorAll(".validated-form input").forEach((field) => {
  // Validate on input (real-time)
  field.addEventListener("input", () => validateField(field));

  // Validate on blur (when user leaves the field)
  field.addEventListener("blur", () => {
    if (field.value) validateField(field);
  });
});

document.querySelector(".validated-form").addEventListener("submit", (e) => {
  e.preventDefault();

  const fields = e.target.querySelectorAll("input");
  const results = [...fields].map((f) => validateField(f));
  const isValid = results.every(Boolean);

  if (isValid) {
    showSuccessMessage("Form submitted successfully!");

    // Clear all field states
    document.querySelectorAll(".field-wrapper").forEach((w) => {
      w.classList.remove("state-error", "state-success");
      const msg = w.querySelector(".field-message");
      if (msg) msg.textContent = "";
    });

    e.target.reset();
  } else {
    // Scroll to first error
    const firstError = document.querySelector(".state-error input");
    if (firstError) {
      firstError.focus();
      firstError.scrollIntoView({ behavior: "smooth", block: "center" });
    }
  }
});

// ================================================================
console.log("✅ Form Validation initialized!");
// ================================================================
