<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Student</h1>
        <form action="{{ route('students.update', $student) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label>Roll Number</label>
                <input type="text" name="roll_number" class="form-control" value="{{ $student->roll_number }}" required>
            </div>
            <div class="mb-3">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control" value="{{ $student->first_name }}" required>
            </div>
            <div class="mb-3">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control" value="{{ $student->last_name }}" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ $student->email }}" required>
            </div>
            <div class="mb-3">
                <label>GPA</label>
                <input type="number" name="gpa" step="0.01" class="form-control" value="{{ $student->gpa }}">
            </div>
            <div class="mb-3">
                <label>Year of Study</label>
                <input type="number" name="year_of_study" class="form-control" value="{{ $student->year_of_study }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>