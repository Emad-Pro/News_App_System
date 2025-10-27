<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المسار غير موجود</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #1f1c2c, #928dab);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            height: 100vh;
            text-align: center;
        }

        h1 {
            font-size: 4rem;
            margin-bottom: 10px;
        }

        p {
            font-size: 1.2rem;
            margin: 10px 0;
        }

        .button {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 28px;
            background-color: #00ADB5;
            color: #fff;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .button:hover {
            background-color: #02C39A;
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        footer {
            position: absolute;
            bottom: 20px;
            font-size: 0.9rem;
            color: #ddd;
        }
        @media (max-width: 768px) {
            h1 {
                font-size: 3rem;
            }
            p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>

    <h1>😅 404</h1>
    <p>يبدو أنك ذهبت في مسار خاطئ!</p>
    <p>لكن لا تقلق، يمكنك العودة إلى الصفحة الرئيسية.</p>

    <a href="{{ url('/') }}" class="button">العودة إلى الصفحة الرئيسية</a>

    <footer>
        <p>تم برمجة قاعدة البيانات بواسطة <strong>Eng. Emad Younis</strong></p>
        <p>وتم برمجة التطبيق بواسطة <strong>Eng. Radwa</strong></p>
        <p>© {{ date('Y') }} جميع الحقوق محفوظة</p>
    </footer>

</body>
</html>
