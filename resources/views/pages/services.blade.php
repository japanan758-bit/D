<x-layouts.app title="خدماتنا الطبية" description="خدمات شاملة ومتخصصة في طب العيون - جراحات الشبكية والمياه البيضاء">

<!-- Hero Section -->
<section class="bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl lg:text-5xl font-bold mb-6">خدماتنا الطبية</h1>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                {{ __('نقدم مجموعة شاملة من الخدمات المتخصصة في طب العيون بأعلى معايير الجودة') }}
            </p>
        </div>
    </div>
</section>

<!-- Services Grid -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- Service 1: جراحات الشبكية -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="p-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-blue-700 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">جراحات الشبكية</h3>
                    <p class="text-gray-600 mb-4 text-center">علاج متقدم لأمراض الشبكية باستخدام أحدث التقنيات الجراحية</p>
                    <ul class="text-sm text-gray-700 space-y-2 mb-6">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            علاج انفصال الشبكية
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            علاج الجلوكوما
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            علاج تليف الشبكية
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            حقن العين الخلفية
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Service 2: جراحات المياه البيضاء -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="p-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-600 to-green-700 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">جراحات المياه البيضاء</h3>
                    <p class="text-gray-600 mb-4 text-center">إزالة المياه البيضاء بتقنية الفاكو مع زرع عدسات حديثة</p>
                    <ul class="text-sm text-gray-700 space-y-2 mb-6">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            الفاكو المعياري
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            زرع العدسات متعددة البؤر
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            زرع عدسات TORIC
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            جراحات المياه البيضاء المعقدة
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Service 3: فحص شامل للعيون -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="p-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-700 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                            <path d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">فحص شامل للعيون</h3>
                    <p class="text-gray-600 mb-4 text-center">فحوصات شاملة ومتطورة لتشخيص وعلاج أمراض العيون</p>
                    <ul class="text-sm text-gray-700 space-y-2 mb-6">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            فحص النظر والقوة البصرية
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            فحص قاع العين
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            فحص ضغط العين
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            فحص قوس القرنية
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Service 4: ليزر الشبكية -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="p-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-600 to-red-700 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.5 7.5h15v5h-15z"/>
                            <path d="M10 2.5v15"/>
                            <path d="M2.5 12.5h15"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">ليزر الشبكية</h3>
                    <p class="text-gray-600 mb-4 text-center">علاج أمراض الشبكية بالأشعة الليزرية الدقيقة والآمنة</p>
                    <ul class="text-sm text-gray-700 space-y-2 mb-6">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            ليزر الشبكية المحيطية
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            علاج تسريب الأوعية الدموية
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            علاج ارتشاح الشبكية
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            ليزر YAG للقرنية
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Service 5: علاج الجلوكوما -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="p-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">علاج الجلوكوما</h3>
                    <p class="text-gray-600 mb-4 text-center">تشخيص وعلاج ضغط العين المرتفع وأمراض العصب البصري</p>
                    <ul class="text-sm text-gray-700 space-y-2 mb-6">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            علاج بالأدوية
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            علاج بالليزر
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            جراحة الجلوكوما
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            زراعة الصمامات
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Service 6: عمليات الحول -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="p-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-600 to-yellow-700 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h4a1 1 0 010 2H6.414l2.293 2.293a1 1 0 01-1.414 1.414L5 6.414V8a1 1 0 01-2 0V4z"/>
                            <path d="M17 16a1 1 0 010 2h4a1 1 0 010 2h-4a1 1 0 010 2h4a1 1 0 001.414-.586L18.414 16A1 1 0 0017 15.586V16z"/>
                            <path d="M17 8a1 1 0 00-1.414-1.414L14 8.172 10.828 5a1 1 0 00-1.414 0L3.414 8A1 1 0 002 9.414v2.172A1 1 0 003.414 12l4 4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">عمليات الحول</h3>
                    <p class="text-gray-600 mb-4 text-center">جراحات تصحيح الحول وإعادة التوافق بين العينين</p>
                    <ul class="text-sm text-gray-700 space-y-2 mb-6">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            جراحة عضلات العين
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            علاج ضعف عضلات العين
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            علاج الحول عند الأطفال
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                            متابعة ما بعد العملية
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Process Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">كيفية حجز الموعد</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                {{ __('خطوات بسيطة لحجز موعدك مع د. عبدالناصر الأخصور') }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-600 to-blue-700 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <span class="text-2xl font-bold text-white">1</span>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">احجز الموعد</h3>
                <p class="text-gray-600">املأ نموذج الحجز بالمعلومات المطلوبة</p>
            </div>
            
            <div class="text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-green-600 to-green-700 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <span class="text-2xl font-bold text-white">2</span>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">تأكيد الموعد</h3>
                <p class="text-gray-600">سنقوم بتأكيد موعدك عبر واتساب</p>
            </div>
            
            <div class="text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-600 to-purple-700 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <span class="text-2xl font-bold text-white">3</span>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">زيارة العيادة</h3>
                <p class="text-gray-600">احضر في الموعد المحدد للفحص</p>
            </div>
            
            <div class="text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-orange-600 to-orange-700 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <span class="text-2xl font-bold text-white">4</span>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">العلاج</h3>
                <p class="text-gray-600">احصل على أفضل رعاية طبية متخصصة</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-blue-700 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold mb-6">{{ __('احجز موعدك الآن') }}</h2>
        <p class="text-xl text-teal-100 mb-8">
            {{ __('لا تتردد في حجز موعدك مع د. عبدالناصر الأخصور للحصول على أفضل رعاية طبية') }}
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('booking') }}" 
               class="bg-white text-blue-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-blue-50 transition-colors">
                {{ __('احجز موعد الآن') }}
            </a>
            <a href="https://wa.me/966123456789" target="_blank"
               class="border-2 border-white text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                {{ __('تواصل عبر واتساب') }}
            </a>
        </div>
    </div>
</section>

</x-layouts.app>