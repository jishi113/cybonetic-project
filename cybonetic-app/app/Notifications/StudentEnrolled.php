<?php

namespace App\Notifications;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class StudentEnrolled extends Notification
{
    use Queueable;

    public function __construct(public Student $student) {}

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Student Enrolled')
            ->line("Student {$this->student->name} enrolled.");
    }

    public function toArray($notifiable)
    {
        return [
            'student_id' => $this->student->id,
            'message' => "Student {$this->student->name} enrolled",
        ];
    }
}