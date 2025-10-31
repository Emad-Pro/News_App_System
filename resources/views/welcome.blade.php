<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}" dir="{{ LaravelLocalization::getCurrentLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.welcome_title') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
    html, body {
        height: 100%;
        margin: 0;
    }
    body {
        font-family: 'Cairo', sans-serif;
        background: linear-gradient(135deg, #283E51, #485563);
        color: #f0f0f0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
        text-align: center;
        direction: inherit;
    }

    main {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
    }

    .card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 40px;
        text-align: center;
        max-width: 600px;
        width: 100%;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    h1 {
        font-size: 2.5rem;
        margin-bottom: 20px;
        color: #fff;
        font-weight: 700;
    }

    p {
        font-size: 1.1rem;
        margin: 8px 0;
        line-height: 1.6;
    }

    /* قسم التحديثات */
    .updates-section {
        margin-top: 30px;
        text-align: start;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        padding-top: 20px;
    }

    /* استخدم استعلامات الاتجاه */
    [dir="rtl"] .updates-section {
        text-align: right;
    }

    [dir="ltr"] .updates-section {
        text-align: left;
    }

    .updates-section h2 {
        font-size: 1.3rem;
        margin-bottom: 15px;
        color: #00ADB5;
    }

    .updates-section i {
        margin-inline-start: 10px;
    }

    .updates-section ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .updates-section li {
        padding: 5px 0;
        font-size: 1rem;
        opacity: 0.9;
    }

    /* الأزرار */
    .button-container {
        margin-top: 40px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 15px;
    }

    a.button {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 28px;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        font-size: 1rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .button.primary {
        background-color: #00ADB5;
        color: #fff;
    }

    .button.secondary {
        background-color: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    .button:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.25);
    }

    footer {
        width: 100%;
        text-align: center;
        padding: 20px 0;
        font-size: 0.9rem;
        color: #bbb;
    }

    /* النافذة المنبثقة */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.85);
        backdrop-filter: blur(5px);
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        position: relative;
        width: 90%;
        max-width: 800px;
    }

    .video-wrapper {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 */
        height: 0;
    }

    .video-wrapper iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 10px;
    }

    .close-button {
        position: absolute;
        top: -40px;
        inset-inline-end: 0; /* بدل right */
        color: #fff;
        font-size: 35px;
        font-weight: bold;
        cursor: pointer;
        transition: color 0.2s;
    }

    .close-button:hover {
        color: #00ADB5;
    }

    @media (max-width: 768px) {
        .card { padding: 30px; }
        h1 { font-size: 2rem; }
        .updates-section h2 { font-size: 1.2rem; }
        .button-container { flex-direction: column; align-items: center; }
    }
</style>
</head>
<body>

    <main>
        <div class="card">
            <h1>{{ __('messages.welcome_title') }}</h1>
            <p>{{ __('messages.welcome_description') }}</p>

            <div class="updates-section">
                <h2><i class="fas fa-rocket"></i>{{ __('messages.latest_updates') }} </h2>
                <ul>
                    <li><i class="fas fa-check-circle"></i> {{ __('messages.update_api_speed') }} </li>
                    <li><i class="fas fa-palette"></i> {{ __('messages.update_design') }} </li>
                    <li><i class="fas fa-shield-alt"></i>{{ __('messages.update_security') }} </li>
                </ul>
            </div>

            <div class="button-container">
                <a href="{{ route('admin.dashboard') }}" class="button primary">
                    <i class="fas fa-tachometer-alt"></i>
                    {{ __('messages.go_to_dashboard') }}
                </a>
                <a href="#" id="openVideoBtn" class="button secondary">
                    <i class="fas fa-play-circle"></i>
                    {{ __('messages.watch_demo') }}
                </a>
            </div>
        </div>
    </main>

    <footer>
        &copy; {{ date('Y') }} {{ __('messages.footer_text') }}
    </footer>

    <div id="videoModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <div class="video-wrapper">
                <iframe id="demoVideo" width="560" height="315" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <script>
        // جلب العناصر
        const modal = document.getElementById('videoModal');
        const openBtn = document.getElementById('openVideoBtn');
        const closeBtn = document.querySelector('.close-button');
        const videoFrame = document.getElementById('demoVideo');
        const videoSrc = videoFrame.src; // حفظ رابط الفيديو الأصلي

        // عند الضغط على زر "مشاهدة فيديو"
        openBtn.onclick = function(e) {
            e.preventDefault(); // منع سلوك الرابط الافتراضي
            modal.style.display = 'flex';
            videoFrame.src = videoSrc; // إعادة تعيين الرابط لضمان التشغيل
        }

        // دالة إغلاق النافذة
        function closeModal() {
            modal.style.display = 'none';
            videoFrame.src = ''; // إيقاف الفيديو عند الإغلاق لمنع تشغيله في الخلفية
        }

        // عند الضغط على زر الإغلاق (X)
        closeBtn.onclick = closeModal;

        // عند الضغط على أي مكان خارج الفيديو
        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>

</body>
</html>