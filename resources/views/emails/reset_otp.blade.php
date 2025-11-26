<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>رمز التحقق</title>
</head>
<body style="font-family: Arial, sans-serif; text-align: center; background-color: #f4f4f4; padding: 20px;">
    <div style="background-color: #ffffff; padding: 30px; border-radius: 10px; max-width: 500px; margin: 0 auto;">
        <h2 style="color: #333;">استعادة كلمة المرور</h2>
        <p style="color: #666; font-size: 16px;">لقد طلبت إعادة تعيين كلمة المرور الخاصة بك.</p>
        <p style="color: #666; font-size: 16px;">استخدم الرمز التالي لإكمال العملية:</p>
        
        <div style="margin: 20px 0;">
            <span style="font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #00ADB5; background: #eee; padding: 10px 20px; border-radius: 5px;">
                {{ $otp }}
            </span>
        </div>

        <p style="color: #999; font-size: 12px;">هذا الرمز صالح لمدة 15 دقيقة.</p>
        <p style="color: #999; font-size: 12px;">إذا لم تطلب هذا الرمز، يرجى تجاهل الرسالة.</p>
    </div>
</body>
</html>