<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>{{ $service->name }} - عيادة د. عبد الناصر الأخرس</title>
    <meta name="description" content="{{ $service->description }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <style>
        .service-content {
            line-height: 1.8;
        }
        .service-content h1,
        .service-content h2,
        .service-content h3,
        .service-content h4,
        .service-content h5,
        .service-content h6 {
            font-weight: bold;
            margin: 1.5em 0 0.5em 0;
            color: #1f2937;
        }
        .service-content h1 { font-size: 2em; }
        .service-content h2 { font-size: 1.5em; }
        .service-content h3 { font-size: 1.25em; }
        .service-content h4 { font-size: 1.125em; }
        .service-content p {
            margin-bottom: 1em;
            color: #4b5563;
        }
        .service-content ul,
        .service-content ol {
            margin: 1em 0;
            padding-right: 1.5em;
        }
        .service-content li {
            margin-bottom: 0.5em;
            color: #4b5563;
        }
        .service-content strong {
            font-weight: bold;
            color: #1f2937;
        }
        .service-content em {
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
                            <a href="{{ route('services') }}" class="text-blue-600 px-3 py-2 text-sm font-medium border-b-2 border-blue-600">خدماتنا</a>
                            <a href="{{ route('articles') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">المقالات</a>
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
                        <a href="{{ route('services') }}" class="text-blue-600 block px-3 py-2 text-base font-medium">خدماتنا</a>
                        <a href="{{ route('articles') }}" class="text-gray-600 hover:text-blue-600 block px-3 py-2 text-base font-medium">المقالات</a>
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
                                <a href="{{ route('services') }}" class="mr-4 text-sm font-medium text-gray-500 hover:text-gray-700">خدماتنا</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="mr-4 text-sm font-medium text-gray-900">{{ Str::limit($service->name, 50) }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Service Header -->
        <div class="bg-white py-12">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <!-- Service Icon -->
                    <div class="mx-auto h-24 w-24 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="h-12 w-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>

                    <!-- Service Title -->
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">{{ $service->name }}</h1>

                    <!-- Service Category -->
                    @if($service->category)
                        <span class="inline-block bg-blue-100 text-blue-800 text-sm font-semibold px-3 py-1 rounded-full mb-6">
                            {{ $service->category }}
                        </span>
                    @endif

                    <!-- Service Description -->
                    <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">{{ $service->description }}</p>

                    <!-- Service Meta -->
                    <div class="flex flex-wrap justify-center items-center text-sm text-gray-500 space-x-6 space-x-reverse">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            <span class="font-semibold text-blue-600">{{ number_format($service->price, 2) }} جنيه</span>
                        </div>
                        @if($service->duration)
                            <div class="flex items-center mb-2">
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $service->duration }} دقيقة
                            </div>
                        @endif
                        @if($service->is_active)
                            <div class="flex items-center mb-2">
                                <div class="w-3 h-3 bg-green-400 rounded-full ml-2"></div>
                                متاح الآن
                            </div>
                        @endif
                    </div>

                    <!-- CTA Buttons -->
                    <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                        <button onclick="openBookingModal('{{ $service->name }}')" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                            احجز موعد
                        </button>
                        <a href="https://wa.me/201055558199?text=أريد الاستفسار عن خدمة: {{ urlencode($service->name) }}" target="_blank" class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                            استفسار واتساب
                        </a>
                        <a href="{{ route('contact') }}" class="border border-gray-300 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-colors">
                            اتصل بنا
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Service Content -->
        <div class="py-8 bg-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                @if($service->content)
                    <div class="bg-gray-50 rounded-xl p-8 mb-8">
                        <div class="service-content">
                            {!! $service->content !!}
                        </div>
                    </div>
                @endif

                <!-- Service Features -->
                @if($service->features && count($service->features) > 0)
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">مميزات الخدمة</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($service->features as $feature)
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mt-0.5 ml-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Service Requirements -->
                @if($service->requirements && count($service->requirements) > 0)
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">متطلبات الخدمة</h2>
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                            <div class="flex">
                                <svg class="w-6 h-6 text-yellow-400 mt-0.5 ml-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <ul class="space-y-2">
                                    @foreach($service->requirements as $requirement)
                                        <li class="text-gray-700">{{ $requirement }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Service Preparation -->
                @if($service->preparation)
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">التحضيرات المطلوبة</h2>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                            <div class="service-content">
                                {!! $service->preparation !!}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Aftercare Instructions -->
                @if($service->aftercare)
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">العناية بعد الإجراء</h2>
                        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                            <div class="service-content">
                                {!! $service->aftercare !!}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Related Services -->
        @if($relatedServices && count($relatedServices) > 0)
            <div class="py-16 bg-gray-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">خدمات أخرى متعلقة</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($relatedServices as $relatedService)
                            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow overflow-hidden">
                                <div class="p-6">
                                    <!-- Service Icon -->
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                        </svg>
                                    </div>

                                    <!-- Service Title -->
                                    <h3 class="text-xl font-bold text-gray-900 mb-3">
                                        <a href="{{ route('service-detail', $relatedService->id) }}" class="hover:text-blue-600 transition-colors">
                                            {{ $relatedService->name }}
                                        </a>
                                    </h3>

                                    <!-- Service Description -->
                                    <p class="text-gray-600 mb-4 line-clamp-3">
                                        {{ Str::limit($relatedService->description, 120) }}
                                    </p>

                                    <!-- Service Meta -->
                                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                        <span class="font-semibold text-blue-600">{{ number_format($relatedService->price, 2) }} جنيه</span>
                                        @if($relatedService->duration)
                                            <span>{{ $relatedService->duration }} دقيقة</span>
                                        @endif
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex gap-2">
                                        <a href="{{ route('service-detail', $relatedService->id) }}" class="flex-1 bg-blue-50 text-blue-600 py-2 px-4 rounded-lg text-center text-sm font-semibold hover:bg-blue-100 transition-colors">
                                            التفاصيل
                                        </a>
                                        <button onclick="openBookingModal('{{ $relatedService->name }}')" class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors">
                                            احجز
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Testimonials for this service -->
        @if($serviceTestimonials && count($serviceTestimonials) > 0)
            <div class="py-16 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">آراء المرضى في هذه الخدمة</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($serviceTestimonials as $testimonial)
                            <div class="bg-gray-50 rounded-xl p-6">
                                <!-- Rating -->
                                <div class="flex items-center mb-4">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $testimonial->rating)
                                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>

                                <!-- Comment -->
                                <p class="text-gray-700 mb-4 italic">"{{ $testimonial->comment }}"</p>

                                <!-- Patient Info -->
                                <div class="text-sm text-gray-600">
                                    <span class="font-semibold">{{ $testimonial->patient_name }}</span>
                                    @if($testimonial->service_name)
                                        <span class="text-gray-500"> - {{ $testimonial->service_name }}</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Booking Modal -->
        <div id="booking-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">حجز موعد</h3>
                    <button onclick="closeBookingModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="mb-4">
                    <p class="text-gray-600 mb-4">خدمة: <span id="modal-service-name" class="font-semibold"></span></p>
                    <p class="text-sm text-gray-500">سيتم توجيهك إلى واتساب لإتمام الحجز</p>
                </div>
                
                <div class="flex gap-4">
                    <button onclick="bookViaWhatsApp()" class="flex-1 bg-green-600 text-white py-2 px-4 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                        واتساب
                    </button>
                    <button onclick="closeBookingModal()" class="flex-1 border border-gray-300 text-gray-700 py-2 px-4 rounded-lg font-semibold hover:bg-gray-50 transition-colors">
                        إلغاء
                    </button>
                </div>
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

        // Booking Modal Functions
        function openBookingModal(serviceName) {
            document.getElementById('modal-service-name').textContent = serviceName;
            document.getElementById('booking-modal').classList.remove('hidden');
        }

        function closeBookingModal() {
            document.getElementById('booking-modal').classList.add('hidden');
        }

        function bookViaWhatsApp() {
            const serviceName = document.getElementById('modal-service-name').textContent;
            const message = `أريد حجز موعد لخدمة: ${serviceName}`;
            const whatsappUrl = `https://wa.me/201055558199?text=${encodeURIComponent(message)}`;
            window.open(whatsappUrl, '_blank');
            closeBookingModal();
        }

        // Close modal when clicking outside
        document.getElementById('booking-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeBookingModal();
            }
        });
    </script>
</body>
</html>