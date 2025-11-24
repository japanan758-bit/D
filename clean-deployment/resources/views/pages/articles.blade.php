<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>المقالات الطبية - عيادة د. عبد الناصر الأخرس</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <h1 class="text-2xl font-bold text-blue-600">د. عبد الناصر الأخرس</h1>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden md:block">
                        <div class="mr-10 flex items-baseline space-x-4 space-x-reverse">
                            <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">الرئيسية</a>
                            <a href="{{ route('about') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">عن العيادة</a>
                            <a href="{{ route('services') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">خدماتنا</a>
                            <a href="{{ route('articles') }}" class="text-blue-600 px-3 py-2 text-sm font-medium border-b-2 border-blue-600">المقالات</a>
                            <a href="{{ route('testimonials') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">آراء المرضى</a>
                            <a href="{{ route('faq') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">الأسئلة الشائعة</a>
                            <a href="{{ route('contact') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">تواصل معنا</a>
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button type="button" class="text-gray-600 hover:text-blue-600 focus:outline-none" onclick="toggleMobileMenu()">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Navigation Menu -->
                <div id="mobile-menu" class="md:hidden hidden">
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-gray-50">
                        <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 block px-3 py-2 text-base font-medium">الرئيسية</a>
                        <a href="{{ route('about') }}" class="text-gray-600 hover:text-blue-600 block px-3 py-2 text-base font-medium">عن العيادة</a>
                        <a href="{{ route('services') }}" class="text-gray-600 hover:text-blue-600 block px-3 py-2 text-base font-medium">خدماتنا</a>
                        <a href="{{ route('articles') }}" class="text-blue-600 block px-3 py-2 text-base font-medium">المقالات</a>
                        <a href="{{ route('testimonials') }}" class="text-gray-600 hover:text-blue-600 block px-3 py-2 text-base font-medium">آراء المرضى</a>
                        <a href="{{ route('faq') }}" class="text-gray-600 hover:text-blue-600 block px-3 py-2 text-base font-medium">الأسئلة الشائعة</a>
                        <a href="{{ route('contact') }}" class="text-gray-600 hover:text-blue-600 block px-3 py-2 text-base font-medium">تواصل معنا</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="bg-gradient-to-l from-blue-600 to-blue-800 text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl md:text-6xl font-bold mb-6">المقالات الطبية</h1>
                    <p class="text-xl md:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto">
                        اكتشف مقالاتنا الطبية المتخصصة والنصائح الصحية المفيدة
                    </p>
                </div>
            </div>
        </div>

        <!-- Articles Section -->
        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Categories Filter -->
                <div class="mb-12 text-center">
                    <div class="flex flex-wrap justify-center gap-4">
                        <button onclick="filterArticles('all')" class="category-btn bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 transition-colors" data-category="all">
                            جميع المقالات
                        </button>
                        <button onclick="filterArticles('نصائح صحية')" class="category-btn bg-gray-200 text-gray-700 px-6 py-2 rounded-full hover:bg-blue-600 hover:text-white transition-colors" data-category="نصائح صحية">
                            نصائح صحية
                        </button>
                        <button onclick="filterArticles('أمراض')" class="category-btn bg-gray-200 text-gray-700 px-6 py-2 rounded-full hover:bg-blue-600 hover:text-white transition-colors" data-category="أمراض">
                            أمراض
                        </button>
                        <button onclick="filterArticles('علاج')" class="category-btn bg-gray-200 text-gray-700 px-6 py-2 rounded-full hover:bg-blue-600 hover:text-white transition-colors" data-category="علاج">
                            علاج
                        </button>
                        <button onclick="filterArticles('تغذية')" class="category-btn bg-gray-200 text-gray-700 px-6 py-2 rounded-full hover:bg-blue-600 hover:text-white transition-colors" data-category="تغذية">
                            تغذية
                        </button>
                    </div>
                </div>

                <!-- Articles Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($articles as $article)
                        <article class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow overflow-hidden article-card" data-category="{{ $article->category }}">
                            <!-- Article Image -->
                            @if($article->featured_image)
                                <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif

                            <!-- Article Content -->
                            <div class="p-6">
                                <!-- Category Badge -->
                                <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full mb-3">
                                    {{ $article->category }}
                                </span>

                                <!-- Article Title -->
                                <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2">
                                    <a href="{{ route('article-detail', $article->slug) }}" class="hover:text-blue-600 transition-colors">
                                        {{ $article->title }}
                                    </a>
                                </h3>

                                <!-- Article Excerpt -->
                                <p class="text-gray-600 mb-4 line-clamp-3">
                                    {{ Str::limit($article->excerpt, 150) }}
                                </p>

                                <!-- Article Meta -->
                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 012 0v4h4V3a1 1 0 012 0v4h4v14H8V7z"></path>
                                        </svg>
                                        {{ $article->published_at->format('d/m/Y') }}
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        {{ $article->views_count }} مشاهدة
                                    </div>
                                </div>

                                <!-- Read More Button -->
                                <div class="mt-6">
                                    <a href="{{ route('article-detail', $article->slug) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold transition-colors">
                                        اقرأ المزيد
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">لا توجد مقالات متاحة</h3>
                            <p class="text-gray-600">سيتم نشر مقالات جديدة قريباً</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($articles->hasPages())
                    <div class="mt-12 flex justify-center">
                        {{ $articles->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-blue-600 text-white py-16">
            <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold mb-4">هل تحتاج لاستشارة طبية؟</h2>
                <p class="text-xl text-blue-100 mb-8">احجز موعدك الآن مع د. عبد الناصر الأخرس</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('booking') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors">
                        احجز موعد
                    </a>
                    <a href="https://wa.me/201055558199" class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors" target="_blank">
                        واتساب
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Clinic Info -->
                    <div>
                        <h3 class="text-xl font-bold mb-4">عيادة د. عبد الناصر الأخرس</h3>
                        <p class="text-gray-400 mb-4">عيادة متخصصة في تقديم أفضل الخدمات الطبية</p>
                        <div class="flex space-x-4 space-x-reverse">
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.347-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.746-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001 12.017.001z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-xl font-bold mb-4">روابط سريعة</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors">الرئيسية</a></li>
                            <li><a href="{{ route('services') }}" class="text-gray-400 hover:text-white transition-colors">خدماتنا</a></li>
                            <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white transition-colors">عن العيادة</a></li>
                            <li><a href="{{ route('booking') }}" class="text-gray-400 hover:text-white transition-colors">احجز موعد</a></li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h3 class="text-xl font-bold mb-4">معلومات التواصل</h3>
                        <div class="space-y-2 text-gray-400">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                القاهرة، مصر
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                01055558199
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                info@clinica.com
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                    <p>&copy; 2024 عيادة د. عبد الناصر الأخرس. جميع الحقوق محفوظة.</p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Mobile Menu Toggle
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        }

        // Articles Filter
        function filterArticles(category) {
            const cards = document.querySelectorAll('.article-card');
            const buttons = document.querySelectorAll('.category-btn');

            // Update active button
            buttons.forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white');
                btn.classList.add('bg-gray-200', 'text-gray-700');
            });

            event.target.classList.remove('bg-gray-200', 'text-gray-700');
            event.target.classList.add('bg-blue-600', 'text-white');

            // Filter cards
            if (category === 'all') {
                cards.forEach(card => {
                    card.style.display = 'block';
                });
            } else {
                cards.forEach(card => {
                    if (card.dataset.category === category) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }
        }
    </script>
</body>
</html>