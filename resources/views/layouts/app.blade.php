<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? config('app.name', 'عيادة د. عبدالناصر الأخرس') }}</title>
    
    <!-- Meta tags for SEO -->
    <meta name="description" content="{{ $description ?? 'عيادة د. عبدالناصر الأخرس - استشاري جراحات الشبكية والمياه البيضاء' }}">
    <meta name="keywords" content="عيادة، عيون، شبكية، مياه بيضاء، جلوكوما، د. عبدالناصر الأخرس">
    <meta name="author" content="عيادة د. عبدالناصر الأخرس">
    
    <!-- Open Graph Meta tags -->
    <meta property="og:title" content="{{ $title ?? config('app.name', 'عيادة د. عبدالناصر الأخرس') }}">
    <meta property="og:description" content="{{ $description ?? 'عيادة د. عبدالناصر الأخرس - استشاري جراحات الشبكية والمياه البيضاء' }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="{{ app()->getLocale() == 'ar' ? 'ar_AR' : 'en_US' }}">
    <meta property="og:image" content="{{ asset('images/logo-main.jpg') }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-main.jpg') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Livewire -->
    @livewireStyles
    
    <!-- Custom RTL CSS -->
    <style>
        body {
            font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.7;
        }
        
        /* RTL Support */
        [dir="rtl"] {
            text-align: right;
        }
        
        [dir="rtl"] .flex {
            flex-direction: row-reverse;
        }
        
        [dir="rtl"] .text-left {
            text-align: right;
        }
        
        [dir="rtl"] .text-right {
            text-align: left;
        }
        
        [dir="rtl"] .ml-auto {
            margin-left: 0;
            margin-right: auto;
        }
        
        [dir="rtl"] .mr-auto {
            margin-right: 0;
            margin-left: auto;
        }
        
        /* Loading Animation */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
        
        .loading-spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #2563eb;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #2563eb;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #1d4ed8;
        }

        /* Hero Section Animations */
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }
            33% {
                transform: translate(30px, -50px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeInUp 0.5s ease-out;
        }

        /* Smooth transitions for better UX */
        * {
            transition: all 0.2s ease-in-out;
        }

        /* Enhanced form styling */
        input:focus, textarea:focus, select:focus {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Button hover effects */
        button:hover, .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased">
    <!-- Loading Overlay -->
    <div id="loading-overlay" class="loading-overlay" style="display: none;">
        <div class="loading-spinner"></div>
    </div>

    <!-- Navigation -->
    @include('components.navbar')

    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    @include('components.footer')

    <!-- WhatsApp Float Button -->
    <div class="fixed bottom-6 right-6 z-40">
        <a href="https://wa.me/966112345678?text={{ urlencode(__('مرحباً، أود حجز موعد')) }}" 
           target="_blank" 
           class="bg-green-500 hover:bg-green-600 text-white p-4 rounded-full shadow-lg transition-all duration-300 transform hover:scale-110 flex items-center justify-center"
           title="{{ __('تواصل عبر واتساب') }}">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.570-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
            </svg>
        </a>
    </div>

    <!-- Chat Widget -->
    @include('components.advanced-chat-widget')

    <!-- Scripts -->
    @livewireScripts
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Show loading overlay for page transitions
        document.addEventListener('DOMContentLoaded', function() {
            // Hide loading overlay after page load
            setTimeout(() => {
                document.getElementById('loading-overlay').style.display = 'none';
            }, 500);
        });

        // Show loading overlay for form submissions
        document.addEventListener('submit', function() {
            document.getElementById('loading-overlay').style.display = 'flex';
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>

    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>