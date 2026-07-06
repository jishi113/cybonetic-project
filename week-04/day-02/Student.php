<?php
// =============================================
// STUDENT CLASS WITH INHERITANCE
// =============================================

require_once 'Validator.php';

class Student {
    use Validator;

    public int $id;
    public string $name;
    private string $email;
    protected float $gpa;
    public static int $count = 0;

    // Constructor
    public function __construct(int $id, string $name, string $email, float $gpa) {
        $this->id = $id;
        $this->setName($name);
        $this->setEmail($email);
        $this->gpa = $gpa;
        self::$count++;
    }

    // Getter for email
    public function getEmail(): string {
        return $this->email;
    }

    // Setter for email with validation
    public function setEmail(string $email): void {
        if (!$this->isEmail($email)) {
            throw new InvalidArgumentException("Invalid email: $email");
        }
        $this->email = $email;
    }

    // Setter for name with validation
    public function setName(string $name): void {
        if (!$this->minLength($name, 2)) {
            throw new InvalidArgumentException("Name must be at least 2 characters");
        }
        $this->name = $name;
    }

    // Get grade based on GPA
    public function getGrade(): string {
        return match(true) {
            $this->gpa >= 9.0 => "A+",
            $this->gpa >= 8.0 => "A",
            $this->gpa >= 7.0 => "B",
            $this->gpa >= 6.0 => "C",
            default => "D",
        };
    }

    // Convert to array
    public function toArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'gpa' => $this->gpa,
            'grade' => $this->getGrade()
        ];
    }

    // Factory method - create from array
    public static function fromArray(array $data): static {
        return new static(
            $data['id'],
            $data['name'],
            $data['email'],
            $data['gpa']
        );
    }

    // Static method to get count
    public static function getCount(): int {
        return self::$count;
    }

    // Magic toString method
    public function __toString(): string {
        return "Student #{$this->id}: {$this->name} (GPA: {$this->gpa})";
    }

    // Destructor
    public function __destruct() {
        // Optional cleanup
    }
}

// =============================================
// GRADUATE STUDENT (INHERITANCE)
// =============================================

class GraduateStudent extends Student {
    public string $researchTopic;
    private string $supervisor;

    public function __construct(
        int $id,
        string $name,
        string $email,
        float $gpa,
        string $researchTopic,
        string $supervisor
    ) {
        parent::__construct($id, $name, $email, $gpa);
        $this->researchTopic = $researchTopic;
        $this->supervisor = $supervisor;
    }

    // Override parent method
    public function getGrade(): string {
        $parentGrade = parent::getGrade();
        return "$parentGrade (Graduate)";
    }

    // Override toString
    public function __toString(): string {
        return parent::__toString() . " — Research: {$this->researchTopic}";
    }
}
?>