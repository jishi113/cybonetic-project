<!DOCTYPE html>
<html>
<head>
    <title>Student Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Student Details</h1>
        <div class="card">
            <div class="card-body">
                <p><strong>Roll Number:</strong> {{ $student->roll_number }}</p>
                <p><strong>Name:</strong> {{ $student->first_name }} {{ $student->last_name }}</p>
                <p><strong>Email:</strong> {{ $student->email }}</p>
                <p><strong>GPA:</strong> {{ $student->gpa }}</p>
                <p><strong>Year:</strong> {{ $student->year_of_study }}</p>
            </div>
        </div>
        <a href="{{ route('students.index') }}" class="btn btn-secondary mt-3">Back</a>
    </div>
</body>
</html>