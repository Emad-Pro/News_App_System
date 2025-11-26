<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp; // هذا المتغير سيحمل الرقم

    // نستقبل الرقم عند إنشاء الكلاس
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function build()
    {
        // نحدد عنوان الرسالة وملف التصميم (View)
        return $this->subject('رمز التحقق الخاص بك')
                    ->view('emails.reset_otp');
    }
}