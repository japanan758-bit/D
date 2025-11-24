<x-layouts.app title="المدونة الطبية" description="مقالات طبية شاملة ومفيدة حول صحة العيون من د. عبدالناصر الأخصور">

<!-- Hero Section -->
<section class="bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl lg:text-5xl font-bold mb-6">المدونة الطبية</h1>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                {{ __('مقالات طبية شاملة ومفيدة من د. عبدالناصر الأخصور حول صحة العيون والعناية بها') }}
            </p>
        </div>
    </div>
</section>

<!-- Featured Article -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">مقال مميز</h2>
            <p class="text-xl text-gray-600">آخر المقالات الطبية من د. عبدالناصر الأخصور</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                <!-- Featured Image -->
                <div class="bg-gradient-to-br from-blue-100 to-blue-200 h-64 lg:h-auto flex items-center justify-center">
                    <div class="text-center text-blue-700">
                        <svg class="w-24 h-24 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"/>
                            <path d="M4 9h12v8a2 2 0 01-2 2H6a2 2 0 01-2-2V9z"/>
                        </svg>
                        <p class="text-lg font-semibold">أحدث التطورات في علاج الشبكية</p>
                    </div>
                </div>
                
                <!-- Featured Content -->
                <div class="p-8 lg:p-12">
                    <div class="mb-4">
                        <span class="inline-block bg-blue-100 text-blue-800 text-sm font-semibold px-3 py-1 rounded-full">
                            مميز
                        </span>
                    </div>
                    <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4">
                        {{ __('أحدث التطورات في علاج الشبكية 2025') }}
                    </h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        {{ __('يتحدث د. عبدالناصر الأخصور في هذا المقال عن أحدث التطورات والتقنيات المتقدمة في علاج أمراض الشبكية، بما في ذلك العلاجات الجينية والعلاج بالخلايا الجذعية.') }}
                    </p>
                    <div class="flex items-center mb-6 text-sm text-gray-500">
                        <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        {{ __('15 دقيقة قراءة') }}
                        <span class="mx-2">•</span>
                        <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                        24 نوفمبر 2025
                    </div>
                    <a href="#" class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        {{ __('اقرأ المقال كاملاً') }}
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Articles Grid -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">أحدث المقالات</h2>
            <p class="text-xl text-gray-600">نصائح طبية ومعلومات مفيدة لصحتك البصرية</p>
        </div>

        <!-- Articles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            
            <!-- Article 1 -->
            <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="bg-gradient-to-br from-green-100 to-green-200 h-48 flex items-center justify-center">
                    <div class="text-center text-green-700">
                        <svg class="w-16 h-16 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a2 2 0 002 2h4a2 2 0 002-2V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-sm font-semibold">المياه البيضاء</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="mb-3">
                        <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full">
                            جراحات العيون
                        </span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-blue-600 cursor-pointer">
                        {{ __('أسباب تكون المياه البيضاء والوقاية منها') }}
                    </h3>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        {{ __('مقال شامل يشرح الأسباب الرئيسية لتكون المياه البيضاء وكيفية الوقاية منها عبر نمط حياة صحي وفحوصات دورية.') }}
                    </p>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>20 نوفمبر 2025</span>
                        <span>5 دقيقة قراءة</span>
                    </div>
                </div>
            </article>

            <!-- Article 2 -->
            <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="bg-gradient-to-br from-blue-100 to-blue-200 h-48 flex items-center justify-center">
                    <div class="text-center text-blue-700">
                        <svg class="w-16 h-16 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-sm font-semibold">التكنولوجيا</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="mb-3">
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full">
                            التطورات الطبية
                        </span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-blue-600 cursor-pointer">
                        {{ __('الفاحص الضوئي المقطعي: تقنيات متقدمة') }}
                    </h3>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        {{ __('كيف يعمل جهاز OCT وأهميته في تشخيص أمراض الشبكية بدقة عالية وبدون ألم للمريض.') }}
                    </p>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>18 نوفمبر 2025</span>
                        <span>8 دقيقة قراءة</span>
                    </div>
                </div>
            </article>

            <!-- Article 3 -->
            <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="bg-gradient-to-br from-purple-100 to-purple-200 h-48 flex items-center justify-center">
                    <div class="text-center text-purple-700">
                        <svg class="w-16 h-16 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                        </svg>
                        <p class="text-sm font-semibold">العناية</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="mb-3">
                        <span class="inline-block bg-purple-100 text-purple-800 text-xs font-semibold px-2 py-1 rounded-full">
                            نصائح طبية
                        </span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-blue-600 cursor-pointer">
                        {{ __('أهمية الفحوصات الدورية للعيون') }}
                    </h3>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        {{ __('لماذا يجب إجراء فحوصات العيون بانتظام وكيف يمكن اكتشاف الأمراض مبكراً؟') }}
                    </p>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>15 نوفمبر 2025</span>
                        <span>6 دقيقة قراءة</span>
                    </div>
                </div>
            </article>

            <!-- Article 4 -->
            <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="bg-gradient-to-br from-orange-100 to-orange-200 h-48 flex items-center justify-center">
                    <div class="text-center text-orange-700">
                        <svg class="w-16 h-16 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-sm font-semibold">العادات</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="mb-3">
                        <span class="inline-block bg-orange-100 text-orange-800 text-xs font-semibold px-2 py-1 rounded-full">
                            الوقاية
                        </span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-blue-600 cursor-pointer">
                        {{ __('عادات يومية تحمي عينيك من الإرهاق') }}
                    </h3>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        {{ __('نصائح بسيطة يمكن تطبيقها يومياً للحفاظ على صحة العيون ومنع الإرهاق والتعب.') }}
                    </p>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>12 نوفمبر 2025</span>
                        <span>4 دقيقة قراءة</span>
                    </div>
                </div>
            </article>

            <!-- Article 5 -->
            <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="bg-gradient-to-br from-red-100 to-red-200 h-48 flex items-center justify-center">
                    <div class="text-center text-red-700">
                        <svg class="w-16 h-16 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2L3 7v11a2 2 0 002 2h10a2 2 0 002-2V7l-7-5z"/>
                        </svg>
                        <p class="text-sm font-semibold">الطوارئ</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="mb-3">
                        <span class="inline-block bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded-full">
                            دليل طبي
                        </span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-blue-600 cursor-pointer">
                        {{ __('متى تطلب المساعدة الطبية العاجلة؟') }}
                    </h3>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        {{ __('علامات التحذير التي تتطلب عناية طبية فورية للحفاظ على صحة بصرية.') }}
                    </p>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>10 نوفمبر 2025</span>
                        <span>7 دقيقة قراءة</span>
                    </div>
                </div>
            </article>

            <!-- Article 6 -->
            <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="bg-gradient-to-br from-teal-100 to-teal-200 h-48 flex items-center justify-center">
                    <div class="text-center text-teal-700">
                        <svg class="w-16 h-16 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                        </svg>
                        <p class="text-sm font-semibold">تقنيات</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="mb-3">
                        <span class="inline-block bg-teal-100 text-teal-800 text-xs font-semibold px-2 py-1 rounded-full">
                            إجراءات
                        </span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-blue-600 cursor-pointer">
                        {{ __('تقنية الفاكو: ثورة في جراحات العيون') }}
                    </h3>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        {{ __('كيف غيّرت تقنية الفاكو طريقة إجراء جراحات المياه البيضاء وأصبحت المعيار الذهبي.') }}
                    </p>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>8 نوفمبر 2025</span>
                        <span>10 دقيقة قراءة</span>
                    </div>
                </div>
            </article>

        </div>

        <!-- Load More Button -->
        <div class="text-center">
            <button class="bg-gray-200 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                {{ __('عرض المزيد من المقالات') }}
            </button>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">تصفح حسب الموضوع</h2>
            <p class="text-xl text-gray-600">مقالات مصنفة حسب التخصص الطبي</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            
            <!-- Category 1 -->
            <a href="#" class="bg-white rounded-lg p-6 text-center hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 bg-blue-100 rounded-full mx-auto mb-3 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a2 2 0 002 2h4a2 2 0 002-2V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">المياه البيضاء</h3>
                <p class="text-sm text-gray-600">12 مقال</p>
            </a>

            <!-- Category 2 -->
            <a href="#" class="bg-white rounded-lg p-6 text-center hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 bg-green-100 rounded-full mx-auto mb-3 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">علاج الشبكية</h3>
                <p class="text-sm text-gray-600">8 مقالات</p>
            </a>

            <!-- Category 3 -->
            <a href="#" class="bg-white rounded-lg p-6 text-center hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 bg-purple-100 rounded-full mx-auto mb-3 flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">العناية الوقائية</h3>
                <p class="text-sm text-gray-600">15 مقال</p>
            </a>

            <!-- Category 4 -->
            <a href="#" class="bg-white rounded-lg p-6 text-center hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 bg-orange-100 rounded-full mx-auto mb-3 flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">التكنولوجيا الطبية</h3>
                <p class="text-sm text-gray-600">10 مقالات</p>
            </a>

        </div>
    </div>
</section>

<!-- Newsletter Signup -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-blue-700 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold mb-6">{{ __('اشترك في النشرة الطبية') }}</h2>
        <p class="text-xl text-blue-100 mb-8">
            {{ __('احصل على أحدث المقالات والنصائح الطبية مباشرة في بريدك الإلكتروني') }}
        </p>
        <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
            <input type="email" 
                   placeholder="{{ __('أدخل بريدك الإلكتروني') }}"
                   class="flex-1 px-4 py-3 rounded-lg text-gray-900 text-right"
                   required>
            <button type="submit" 
                    class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors">
                {{ __('اشتراك') }}
            </button>
        </form>
        <p class="text-sm text-blue-200 mt-4">
            {{ __('لن نرسل لك رسائل مزعجة. يمكنك إلغاء الاشتراك في أي وقت.') }}
        </p>
    </div>
</section>

</x-layouts.app>