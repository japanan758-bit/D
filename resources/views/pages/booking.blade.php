<x-layouts.app 
    title="حجز موعد" 
    description="احجز موعدك مع د. عبدالناصر الأخرس - استشاري جراحات الشبكية والمياه البيضاء">
    
    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl lg:text-5xl font-bold mb-4">{{ __('احجز موعدك') }}</h1>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                {{ __('احجز موعدك مع د. عبدالناصر الأخرس بسهولة وسرعة. احصل على أفضل رعاية طبية لعيونك') }}
            </p>
        </div>
    </section>

    <!-- Booking Form Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @livewire('booking-form')
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ __('لماذا تختار عيادتنا؟') }}</h2>
                <p class="text-xl text-gray-600">{{ __('نحن نقدم أفضل رعاية طبية للعيون') }}</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ __('خبرة واسعة') }}</h3>
                    <p class="text-gray-600">{{ __('أكثر من 20 عاماً من الخبرة في جراحات العيون المتقدمة') }}</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ __('تقنيات حديثة') }}</h3>
                    <p class="text-gray-600">{{ __('نستخدم أحدث التقنيات والمعدات الطبية المتطورة') }}</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ __('رعاية شاملة') }}</h3>
                    <p class="text-gray-600">{{ __('نتابع حالة المرضى بعناية فائقة قبل وأثناء وبعد العلاج') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Information -->
    <section class="py-16 bg-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __('معلومات التواصل') }}</h2>
                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="mr-3 rtl:mr-0 rtl:ml-3">
                                <h3 class="text-lg font-semibold text-gray-900">{{ __('عنوان العيادة') }}</h3>
                                <p class="text-gray-600">13 ميدان سفنكس، المهندسين، الجيزة، مصر</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                </svg>
                            </div>
                            <div class="mr-3 rtl:mr-0 rtl:ml-3">
                                <h3 class="text-lg font-semibold text-gray-900">{{ __('الهاتف') }}</h3>
                                <a href="tel:01055558199" class="text-blue-600 hover:text-blue-800">010-5555-8199</a>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                </svg>
                            </div>
                            <div class="mr-3 rtl:mr-0 rtl:ml-3">
                                <h3 class="text-lg font-semibold text-gray-900">{{ __('البريد الإلكتروني') }}</h3>
                                <a href="mailto:info@akhrasclinic.com" class="text-blue-600 hover:text-blue-800">info@akhrasclinic.com</a>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="mr-3 rtl:mr-0 rtl:ml-3">
                                <h3 class="text-lg font-semibold text-gray-900">{{ __('ساعات العمل') }}</h3>
                                <p class="text-gray-600">{{ __('السبت - الخميس: 10:00 - 20:00') }}</p>
                                <p class="text-gray-600">{{ __('الجمعة: مغلق') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __('موقع العيادة') }}</h2>
                    
                    <!-- Map Placeholder -->
                    <div class="bg-gray-200 rounded-lg h-64 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                            <p class="text-gray-600">{{ __('خريطة الموقع') }}</p>
                            <a href="https://maps.google.com/?q=13+Sphinx+Square+El-Mohandessin+Giza" 
                               target="_blank"
                               class="text-blue-600 hover:text-blue-800 text-sm">
                                {{ __('عرض على الخريطة') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>