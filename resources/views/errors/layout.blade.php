<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'حدث خطأ')</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@500;700&display=swap" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #1f1c2c, #928dab);
            color: #fff;
            
            /* -- التعديل الرئيسي هنا -- */
            display: flex;
            flex-direction: column;
            text-align: center;
        }

        /* هذا العنصر سيأخذ كل المساحة المتاحة ويدفع الفوتر للأسفل */
        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        h1 {
            font-size: 6rem;
            margin: 0;
            font-weight: 700;
            text-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        p {
            font-size: 1.4rem;
            margin: 10px 0 30px 0;
            font-weight: 500;
            max-width: 600px; /* يمنع النص من أن يكون عريضًا جدًا على الشاشات الكبيرة */
        }

        .button {
            display: inline-block;
            padding: 12px 28px;
            background-color: #00ADB5;
            color: #fff;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .button:hover {
            background-color: #02C39A;
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        /* تم إزالة position: absolute من الفوتر */
        footer {
            width: 100%;
            padding: 15px 0;
            font-size: 0.9rem;
            color: #ddd;
        }
        
        footer p {
            margin: 5px 0;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            h1 { font-size: 4rem; }
            p { font-size: 1.1rem; }
            .button { padding: 10px 24px; }
        }
    </style>
</head>
<body>

    {{-- تم وضع المحتوى الرئيسي داخل وسم <main> --}}
    <main>
        <h1>@yield('code')</h1>
        <p>@yield('message')</p>
        <a href="{{ url('/') }}" class="button">العودة إلى الصفحة الرئيسية</a>
    </main>

    {{-- الفوتر الآن جزء طبيعي من الصفحة --}}
    <footer>
        <p>تم برمجة قاعدة البيانات بواسطة <strong>Eng. Emad Younis</strong></p>
        <!-- <p>وتم برمجة التطبيق بواسطة <strong>Eng. Radwa</strong></p> -->
        <p>© {{ date('Y') }} جميع الحقوق محفوظة</p>
    </footer>

</body>
</html>