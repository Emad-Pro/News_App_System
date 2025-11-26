<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp; // متغير لحمل الكود

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'رمز إعادة تعيين كلمة المرور',
        );
    }

    public function content(): Content
    {
        // يمكنك استخدام view أو text مباشر
        // للسهولة سنستخدم view بسيط
        return new Content(
            view: 'emails.reset_otp',
        );
    }
}