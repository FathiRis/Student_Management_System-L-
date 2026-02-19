<?php

namespace App\Mail;

use App\Models\ExamAdmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExamAdmissionSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ExamAdmission $admission)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Exam Admission Confirmation'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.exam_admission_submitted'
        );
    }
}
