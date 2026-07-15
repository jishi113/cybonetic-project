<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return '<h1>About Cybonetic</h1>
            <p>We build modern web solutions.</p>
            <a href="/">← Back Home</a>';
})->name('about');

Route::get('/contact', function () {
    return '<h1>Contact Us</h1>
            <p>Email: info@cybonetic.in</p>
            <p>Phone: +91 9876543210</p>
            <a href="/">← Back Home</a>';
})->name('contact');

Route::get('/dashboard', function () {
    return '<h1>📊 Dashboard</h1>
            <p>Welcome to your dashboard!</p>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/about">About</a></li>
                <li><a href="/contact">Contact</a></li>
                <li><a href="/students">Students</a></li>
            </ul>';
})->name('dashboard');

Route::prefix('admin')->group(function () {
    Route::get('/users', function () {
        return '<h1>👥 Admin: Users</h1>
                <p>List of all users (admin only)</p>
                <ul>
                    <li>Jishi (Admin)</li>
                    <li>Priya (Manager)</li>
                    <li>Rahul (Viewer)</li>
                </ul>
                <a href="/dashboard">← Back to Dashboard</a>';
    })->name('admin.users');
    
    Route::get('/settings', function () {
        return '<h1>⚙️ Admin: Settings</h1>
                <p>Application settings (admin only)</p>
                <ul>
                    <li>Site Name: Cybonetic</li>
                    <li>Theme: Dark</li>
                    <li>Language: English</li>
                </ul>
                <a href="/dashboard">← Back to Dashboard</a>';
    })->name('admin.settings');
});

Route::get('/test-routes', function () {
    return '<h1>🧪 Route Testing</h1>
            <table border="1" cellpadding="10">
                <tr><th>Route Name</th><th>URL</th></tr>
                <tr><td>home</td><td>/</td></tr>
                <tr><td>about</td><td>/about</td></tr>
                <tr><td>contact</td><td>/contact</td></tr>
                <tr><td>students.index</td><td>/students</td></tr>
                <tr><td>students.show</td><td>/students/1</td></tr>
                <tr><td>dashboard</td><td>/dashboard</td></tr>
                <tr><td>admin.users</td><td>/admin/users</td></tr>
                <tr><td>admin.settings</td><td>/admin/settings</td></tr>
            </table>
            <br>
            <a href="/">← Back Home</a>';
})->name('test.routes');

// =============================================
// STUDENT RESOURCE ROUTES
// =============================================

Route::resource('students', StudentController::class);