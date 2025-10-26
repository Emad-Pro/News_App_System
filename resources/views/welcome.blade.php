<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مرحبا بك</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #283E51, #485563);
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            text-align: center;
        }

        h1 {
            font-size: 2.2rem;
            margin-bottom: 10px;
            color: #f5f5f5;
        }

        p {
            font-size: 1.1rem;
            margin: 8px 0;
        }

        .button-container {
            margin-top: 30px;
        }

        a.button {
            display: inline-block;
            padding: 14px 30px;
            background-color: #00ADB5;
            color: #fff;
            border-radius: 50px;
            font-weight: bold;
            text-decoration: none;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        a.button:hover {
            background-color: #02C39A;
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        footer {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
            font-size: 0.9rem;
            color: #ddd;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 1.8rem;
            }
            p {
                font-size: 1rem;
            }
            a.button {
                font-size: 1rem;
                padding: 12px 24px;
            }
        }
    </style>
</head>
<body>
    <div class="content">
        <h1>مرحباً بك في نظام الإدارة</h1>
        <p>تم برمجة قاعدة البيانات بواسطة <strong>Eng. Emad Younis</strong></p>
        <p>وتم تطوير واجهة التطبيق بواسطة <strong>Eng. Radwa</strong></p>

        <div class="button-container">
            <a href="{{ route('admin.dashboard') }}" class="button">هل تريد الذهاب إلى لوحة التحكم؟</a>

        </div>
    </div>

    <footer>
        &copy; {{ date('Y') }} جميع الحقوق محفوظة
    </footer>
</body>
</html>
