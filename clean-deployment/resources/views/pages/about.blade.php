<x-layouts.app title="حول العيادة" description="تعرف على د. عبدالناصر الأخرس وخبرته في جراحات العيون">

<!-- Hero Section -->
<section class="bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl lg:text-5xl font-bold mb-6">حول العيادة</h1>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                {{ __('معلومات شاملة عن د. عبدالناصر الأخرس ومسيرته المهنية في طب العيون') }}
            </p>
        </div>
    </div>
</section>

<!-- Doctor Profile Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Doctor Image -->
            <div class="relative">
                <div class="bg-gradient-to-br from-blue-50 to-amber-50 rounded-2xl p-4 relative overflow-hidden">
                    <!-- Background decorations -->
                    <div class="absolute top-4 right-4 w-16 h-16 bg-gradient-to-br from-amber-400 to-amber-600 rounded-full opacity-20 animate-pulse"></div>
                    <div class="absolute bottom-4 left-4 w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full opacity-20 animate-pulse animation-delay-1000"></div>
                    
                    <div class="relative z-10">
                        <img src="{{ asset('images/doctor-formal.jpg') }}" 
                             alt="د. عبدالناصر الأخرس" 
                             class="w-full max-w-md mx-auto rounded-2xl shadow-2xl">
                        
                        <!-- Image overlays -->
                        <div class="absolute bottom-6 left-6 right-6 bg-white bg-opacity-95 backdrop-blur-sm rounded-xl p-4 shadow-lg">
                            <div class="flex items-center justify-center">
                                <img src="{{ asset('images/favicon.png') }}" alt="شعار العيادة" class="w-8 h-8 ml-2">
                                <div class="text-center">
                                    <h3 class="text-lg font-bold text-gray-800">د. عبدالناصر الأخرس</h3>
                                    <p class="text-blue-600 font-semibold text-sm">استشاري جراحات الشبكية والمياه البيضاء</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Additional images showcase -->
                <div class="grid grid-cols-2 gap-4 mt-6">
                    <div class="bg-white rounded-xl p-3 shadow-lg">
                        <img src="{{ asset('images/doctor-casual.jpg') }}" 
                             alt="د. عبدالناصر الأخرس - صورة غير رسمية" 
                             class="w-full h-32 object-cover rounded-lg">
                    </div>
                    <div class="bg-white rounded-xl p-3 shadow-lg">
                        <img src="{{ asset('images/logo-main.jpg') }}" 
                             alt="شعار العيادة" 
                             class="w-full h-32 object-contain rounded-lg">
                    </div>
                </div>
            </div>

            <!-- Doctor Information -->
            <div class="space-y-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">الخبرة والتخصص</h2>
                    <div class="space-y-4 text-gray-700 leading-relaxed">
                        <p class="text-lg">
                            {{ __('د. عبدالناصر الأخصور هو استشاري متخصص في جراحات العيون مع أكثر من 20 عاماً من الخبرة في المجال الطبي.') }}
                        </p>
                        <p>
                            {{ __('تخصص الدكتور في جراحات الشبكية والمياه البيضاء، ويعتبر من الرواد في تطبيق أحدث التقنيات الطبية في المنطقة.') }}
                        </p>
                    </div>
                </div>

                <!-- Education -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">التعليم والشهادات</h3>
                    <ul class="space-y-3 text-gray-700">
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-blue-600 mt-1 ml-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                            </svg>
                            <div>
                                <strong>بكالوريوس الطب والجراحة</strong>
                                <p class="text-gray-600">جامعة القاهرة - 1998</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-blue-600 mt-1 ml-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <strong>ماجستير طب وجراحة العيون</strong>
                                <p class="text-gray-600">القصر العيني - 2003</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-blue-600 mt-1 ml-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                            </svg>
                            <div>
                                <strong>زمالة جراحة الشبكية</strong>
                                <p class="text-gray-600">مستشفى الملك فهد - 2005</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Experience Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">الخبرة المهنية</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                {{ __('مسيرة مهنية حافلة بالإنجازات والخبرات المتنوعة في طب العيون') }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Achievement Cards -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 text-center">
                <div class="w-16 h-16 bg-blue-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">20+ عام</h3>
                <p class="text-gray-600">{{ __('من الخبرة في طب العيون') }}</p>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 text-center">
                <div class="w-16 h-16 bg-green-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">5000+ عملية</h3>
                <p class="text-gray-600">{{ __('جراحة ناجحة') }}</p>
            </div>

            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 text-center">
                <div class="w-16 h-16 bg-purple-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">10000+ مريض</h3>
                <p class="text-gray-600">{{ __('رضا تام للمرضى') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Equipment Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">التقنيات والمعدات</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                {{ __('نستخدم أحدث التقنيات والمعدات الطبية العالمية لضمان أفضل النتائج') }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <h3 class="text-xl font-bold text-gray-900 mb-4">الفاحص الضوئي المقطعي</h3>
                <p class="text-gray-600">OCT (Optical Coherence Tomography) للفحص الدقيق لشبكية العين</p>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <h3 class="text-xl font-bold text-gray-900 mb-4">الليزر الجراحي</h3>
                <p class="text-gray-600">أحدث أجهزة الليزر لعلاج أمراض الشبكية بشكل دقيق وآمن</p>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <h3 class="text-xl font-bold text-gray-900 mb-4">المجهر الجراحي</h3>
                <p class="text-gray-600">مجاهر جراحية متقدمة لضمان دقة عمليات الشبكية</p>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <h3 class="text-xl font-bold text-gray-900 mb-4">الكاميرا الشبكية</h3>
                <p class="text-gray-600">تصوير دقيق ومتابعة حالة الشبكية بانتظام</p>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <h3 class="text-xl font-bold text-gray-900 mb-4">جهاز الموجات فوق الصوتية</h3>
                <p class="text-gray-600">لفحص وإطمئنان على صحة العيون الداخلية</p>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <h3 class="text-xl font-bold text-gray-900 mb-4">مستوى قياس الضغط</h3>
                <p class="text-gray-600">قياس ضغط العين بدقة عالية لمنع الجلوكوما</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-blue-700 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold mb-6">{{ __('جاهز لاستشارة طبية؟') }}</h2>
        <p class="text-xl text-blue-100 mb-8">
            {{ __('احجز موعد الآن مع د. عبدالناصر الأخصور واحصل على أفضل رعاية طبية') }}
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('booking') }}" 
               class="bg-white text-blue-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-blue-50 transition-colors">
                {{ __('احجز موعد الآن') }}
            </a>
            <a href="{{ route('contact') }}" 
               class="border-2 border-white text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                {{ __('تواصل معنا') }}
            </a>
        </div>
    </div>
</section>

</x-layouts.app>