<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>{{ $article->title }} - عيادة د. عبد الناصر الأخرس</title>
    <meta name="description" content="{{ Str::limit($article->excerpt, 150) }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <style>
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .article-content {
            line-height: 1.8;
        }
        .article-content h1,
        .article-content h2,
        .article-content h3,
        .article-content h4,
        .article-content h5,
        .article-content h6 {
            font-weight: bold;
            margin: 1.5em 0 0.5em 0;
            color: #1f2937;
        }
        .article-content h1 { font-size: 2em; }
        .article-content h2 { font-size: 1.5em; }
        .article-content h3 { font-size: 1.25em; }
        .article-content h4 { font-size: 1.125em; }
        .article-content p {
            margin-bottom: 1em;
            color: #4b5563;
        }
        .article-content ul,
        .article-content ol {
            margin: 1em 0;
            padding-right: 1.5em;
        }
        .article-content li {
            margin-bottom: 0.5em;
            color: #4b5563;
        }
        .article-content strong {
            font-weight: bold;
            color: #1f2937;
        }
        .article-content em {
            font-style: italic;
        }
    </style>
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

        <!-- Breadcrumb -->
        <div class="bg-white border-b">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-4 space-x-reverse">
                        <li>
                            <div>
                                <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-500">الرئيسية</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{ route('articles') }}" class="mr-4 text-sm font-medium text-gray-500 hover:text-gray-700">المقالات</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="mr-4 text-sm font-medium text-gray-900">{{ Str::limit($article->title, 50) }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Article Content -->
        <div class="py-8 bg-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <article class="bg-white rounded-xl shadow-sm">
                    <!-- Article Header -->
                    <div class="p-8 pb-0">
                        <!-- Category Badge -->
                        <div class="mb-4">
                            <span class="inline-block bg-blue-100 text-blue-800 text-sm font-semibold px-3 py-1 rounded-full">
                                {{ $article->category }}
                            </span>
                        </div>

                        <!-- Article Title -->
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                            {{ $article->title }}
                        </h1>

                        <!-- Article Meta -->
                        <div class="flex flex-wrap items-center text-sm text-gray-600 mb-8 pb-6 border-b border-gray-200">
                            <div class="flex items-center ml-6 mb-2">
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 012 0v4h4V3a1 1 0 012 0v4h4v14H8V7z"></path>
                                </svg>
                                {{ $article->published_at->format('d/m/Y') }}
                            </div>
                            <div class="flex items-center ml-6 mb-2">
                                <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{ $article->views_count }} مشاهدة
                            </div>
                            <div class="flex items-center ml-6 mb-2">
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ ceil(str_word_count(strip_tags($article->content)) / 200) }} دقائق للقراءة
                            </div>
                            <div class="flex items-center ml-6 mb-2">
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                د. عبد الناصر الأخرس
                            </div>
                        </div>
                    </div>

                    <!-- Article Featured Image -->
                    @if($article->featured_image)
                        <div class="px-8 pb-8">
                            <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" class="w-full h-96 object-cover rounded-xl shadow-lg">
                        </div>
                    @endif

                    <!-- Article Content -->
                    <div class="px-8 pb-8">
                        <div class="article-content prose prose-lg max-w-none">
                            {!! $article->content !!}
                        </div>

                        <!-- Article Tags -->
                        @if($article->tags)
                            <div class="mt-8 pt-8 border-t border-gray-200">
                                <h4 class="text-sm font-semibold text-gray-900 mb-3">الكلمات المفتاحية:</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(',', $article->tags) as $tag)
                                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                                            {{ trim($tag) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Social Share -->
                        <div class="mt-8 pt-8 border-t border-gray-200">
                            <h4 class="text-sm font-semibold text-gray-900 mb-3">شارك هذا المقال:</h4>
                            <div class="flex space-x-4 space-x-reverse">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}" target="_blank" class="text-blue-400 hover:text-blue-600">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                    </svg>
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" target="_blank" class="text-blue-700 hover:text-blue-900">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($article->title . ' - ' . request()->url()) }}" target="_blank" class="text-green-600 hover:text-green-800">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Related Articles -->
                @if($relatedArticles && count($relatedArticles) > 0)
                    <div class="mt-16">
                        <h3 class="text-2xl font-bold text-gray-900 mb-8">مقالات ذات صلة</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($relatedArticles as $relatedArticle)
                                <article class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow overflow-hidden">
                                    @if($relatedArticle->featured_image)
                                        <img src="{{ $relatedArticle->featured_image }}" alt="{{ $relatedArticle->title }}" class="w-full h-40 object-cover">
                                    @else
                                        <div class="w-full h-40 bg-gradient-to-r from-blue-500 to-blue-600"></div>
                                    @endif
                                    
                                    <div class="p-4">
                                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full mb-2">
                                            {{ $relatedArticle->category }}
                                        </span>
                                        
                                        <h4 class="font-bold text-gray-900 mb-2 line-clamp-2">
                                            <a href="{{ route('article-detail', $relatedArticle->slug) }}" class="hover:text-blue-600 transition-colors">
                                                {{ $relatedArticle->title }}
                                            </a>
                                        </h4>
                                        
                                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                            {{ Str::limit($relatedArticle->excerpt, 100) }}
                                        </p>
                                        
                                        <a href="{{ route('article-detail', $relatedArticle->slug) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                                            اقرأ المزيد ←
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                        </div>
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

        // Track article view
        fetch('{{ route('track-article-view', $article->id) }}', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        });
    </script>
</body>
</html>