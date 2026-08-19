<?php
// =============================================
// VALIDATOR TRAIT
// =============================================

trait Validator {
    /**
     * Validate email address
     */
    public function isEmail(string $email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validate Indian phone number (10 digits, starts with 6-9)
     */
    public function isPhone(string $phone): bool {
        return preg_match('/^[6-9]\d{9}$/', $phone) === 1;
    }

    /**
     * Check if value is not empty
     */
    public function isRequired($value): bool {
        if (is_null($value)) return false;
        if (is_string($value)) return trim($value) !== '';
        return !empty($value);
    }

    /**
     * Check if string meets minimum length
     */
    public function minLength(string $value, int $length): bool {
        return strlen($value) >= $length;
    }
}

// =============================================
// TEST CLASS FOR VALIDATOR TRAIT
// =============================================

class ValidatorTest {
    use Validator;
}
?>