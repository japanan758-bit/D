<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>الشروط والأحكام - عيادة د. عبد الناصر الأخرس</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <style>
        .content-section h2 {
            color: #1f2937;
            font-size: 1.5em;
            font-weight: bold;
            margin: 2em 0 1em 0;
        }
        .content-section h3 {
            color: #374151;
            font-size: 1.25em;
            font-weight: 600;
            margin: 1.5em 0 0.75em 0;
        }
        .content-section p {
            margin-bottom: 1em;
            line-height: 1.7;
        }
        .content-section ul {
            margin: 1em 0;
            padding-right: 1.5em;
        }
        .content-section li {
            margin-bottom: 0.5em;
            line-height: 1.6;
        }
        .highlight-box {
            border-right: 4px solid #3B82F6;
            background-color: #EFF6FF;
            padding: 1rem;
            margin: 1.5rem 0;
            border-radius: 0.375rem;
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
                        <a href="{{ route('services') }}" class="text-gray-600 hover:text-blue-600 block px-3 py-2 text-base font-medium">خدماتنا</a>
                        <a href="{{ route('articles') }}" class="text-gray-600 hover:text-blue-600 block px-3 py-2 text-base font-medium">المقالات</a>
                        <a href="{{ route('testimonials') }}" class="text-gray-600 hover:text-blue-600 block px-3 py-2 text-base font-medium">آراء المرضى</a>
                        <a href="{{ route('faq') }}" class="text-gray-600 hover:text-blue-600 block px-3 py-2 text-base font-medium">الأسئلة الشائعة</a>
                        <a href="{{ route('contact') }}" class="text-gray-600 hover:text-blue-600 block px-3 py-2 text-base font-medium">تواصل معنا</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Header -->
        <div class="bg-gradient-to-l from-blue-600 to-blue-800 text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl md:text-6xl font-bold mb-6">الشروط والأحكام</h1>
                    <p class="text-xl md:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto">
                        الشروط والأحكام الخاصة بعيادة د. عبد الناصر الأخرس
                    </p>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="py-16 bg-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="content-section prose prose-lg max-w-none text-gray-700">
                    <p class="text-lg text-gray-600 mb-8">آخر تحديث: {{ now()->format('d/m/Y') }}</p>

                    <div class="highlight-box">
                        <p class="font-semibold text-blue-900 mb-2">إقرار مهم</p>
                        <p class="text-blue-800">
                            باستخدامكم لخدمات عيادة د. عبد الناصر الأخرس وموقعنا الإلكتروني، فإنكم تقرون بقراءة وفهم وقبول جميع الشروط والأحكام المذكورة أدناه.
                        </p>
                    </div>

                    <h2>1. تعريفات</h2>
                    <ul>
                        <li><strong>"العيادة"</strong> تعني عيادة د. عبد الناصر الأخرس وجميع فروعها</li>
                        <li><strong>"المريض"</strong> يعني الشخص الذي يستفيد من خدمات العيادة</li>
                        <li><strong>"الخدمات"</strong> تعني جميع الخدمات الطبية والتشخيصية والعلاجية</li>
                        <li><strong>"الموقع"</strong> يعني الموقع الإلكتروني للعيادة</li>
                        <li><strong>"المحتوى"</strong> يعني النصوص والصور والفيديوهات والمعلومات المتاحة على الموقع</li>
                    </ul>

                    <h2>2. القبول والالتزام</h2>
                    <p>
                        باستخدام موقع العيادة أو الاستفادة من خدماتها، فإنكم توافقون على الالتزام بهذه الشروط والأحكام. إذا كنتم لا توافقون على أي من هذه الشروط، يرجى عدم استخدام خدماتنا.
                    </p>

                    <h2>3. حجز المواعيد</h2>
                    
                    <h3>3.1 طريقة الحجز</h3>
                    <ul>
                        <li>يمكن حجز المواعيد عبر الهاتف أو الموقع الإلكتروني أو التطبيق</li>
                        <li>يجب تقديم معلومات صحيحة ومحدثة عند الحجز</li>
                        <li>سيتم تأكيد الموعد عبر رسالة نصية أو مكالمة هاتفية</li>
                        <li>في حالة عدم الاستجابة للتأكيد، قد يتم إلغاء الموعد</li>
                    </ul>

                    <h3>3.2 إلغاء وإعادة جدولة المواعيد</h3>
                    <ul>
                        <li>يمكن إلغاء أو إعادة جدولة الموعد قبل 24 ساعة على الأقل</li>
                        <li>في حالة الإلغاء المتأخر (أقل من 24 ساعة) قد تطبق رسوم إدارية</li>
                        <li>عدم الحضور للموعد المحدد سيتم اعتباره إلغاء متأخر</li>
                        <li>العيادة تحتفظ بالحق في إلغاء الموعد في حالة الظروف الطارئة</li>
                    </ul>

                    <h2>4. الخدمات الطبية</h2>
                    
                    <h3>4.1 طبيعة الخدمات</h3>
                    <ul>
                        <li>جميع الخدمات المقدمة هي خدمات طبية متخصصة</li>
                        <li>يتم تقديم الخدمات وفقاً لأعلى معايير الرعاية الطبية</li>
                        <li>العيادة غير مسؤولة عن النتائج في حالة عدم اتباع التعليمات الطبية</li>
                    </ul>

                    <h3>4.2 الاستشارة الطبية</h3>
                    <ul>
                        <li>الاستشارة الطبية المقدمة عبر الهاتف أو الموقع هي استشارة أولية</li>
                        <li>للحصول على تشخيص دقيق، يجب الحضور للعيادة للفحص السريري</li>
                        <li>الاستشارة الهاتفية لا تحل محل الفحص الطبي المتخصص</li>
                    </ul>

                    <h2>5. الدفع والفواتير</h2>
                    
                    <h3>5.1 أسعار الخدمات</h3>
                    <ul>
                        <li>يتم عرض أسعار الخدمات على الموقع كمؤشرات تقريبية</li>
                        <li>السعر النهائي قد يختلف حسب حالة المريض وحاجته للعلاج</li>
                        <li>يتم إبلاغ المريض بالسعر النهائي قبل بدء العلاج</li>
                    </ul>

                    <h3>5.2 طرق الدفع</h3>
                    <ul>
                        <li>يمكن الدفع نقداً أو بالبطاقات الائتمانية</li>
                        <li>تتوفر خطط دفع معينة لبعض الخدمات (حسب التقييم)</li>
                        <li>يجب دفع الرسوم الطبية في نفس يوم تقديم الخدمة</li>
                    </ul>

                    <h2>6. معلومات المرضى والسجلات الطبية</h2>
                    
                    <h3>6.1 السرية الطبية</h3>
                    <ul>
                        <li>يتم التعامل مع المعلومات الطبية بسرية تامة وفقاً لقانون السرية الطبية</li>
                        <li>لا يتم مشاركة المعلومات الطبية إلا بموافقة صريحة من المريض</li>
                        <li>يتم حفظ السجلات الطبية بطريقة آمنة وفقاً للقوانين المعمول بها</li>
                    </ul>

                    <h3>6.2 الوصول للسجلات الطبية</h3>
                    <ul>
                        <li>للمريض الحق في الحصول على نسخة من ملفه الطبي</li>
                        <li>يمكن تقديم تقرير طبي مختصر للمريض أو الجهة التي يحددها</li>
                        <li>في حالة نقل المريض لطبيب آخر، يمكن مشاركة المعلومات الطبية</li>
                    </ul>

                    <h2>7. استخدام الموقع</h2>
                    
                    <h3>7.1 الاستخدام المسموح</h3>
                    <ul>
                        <li>استخدام الموقع للأغراض الشخصية فقط</li>
                        <li>استخدام المعلومات للأغراض التعليمية والطبية</li>
                        <li>احترام حقوق الملكية الفكرية للمحتوى</li>
                    </ul>

                    <h3>7.2 الاستخدام المحظور</h3>
                    <ul>
                        <li>استخدام الموقع لأي غرض غير قانوني</li>
                        <li>محاولة إلحاق الضرر بالموقع أو خوادمه</li>
                        <li>نشر محتوى مسيء أو مضلل أو غير مناسب</li>
                        <li>محاولة اختراق أو الوصول غير المصرح به للموقع</li>
                    </ul>

                    <h2>8. الملكية الفكرية</h2>
                    
                    <h3>8.1 حقوق الطبع والنشر</h3>
                    <ul>
                        <li>جميع المحتوى الموجود على الموقع محمي بحقوق الطبع والنشر</li>
                        <li>لا يجوز نسخ أو توزيع أو إعادة نشر المحتوى دون إذن صريح</li>
                        <li>يمكن استخدام المحتوى للأغراض الشخصية والتعليمية مع ذكر المصدر</li>
                    </ul>

                    <h3>8.2 العلامات التجارية</h3>
                    <ul>
                        <li>اسم العيادة وشعارها علامات تجارية مسجلة</li>
                        <li>لا يجوز استخدام هذه العلامات بدون إذن مسبق</li>
                        <li>أي استخدام غير مصرح به قد يعرض المخالف للمساءلة القانونية</li>
                    </ul>

                    <h2>9. المسؤولية والإعفاء</h2>
                    
                    <h3>9.1 حدود المسؤولية</h3>
                    <ul>
                        <li>العيادة غير مسؤولة عن أي أضرار غير مباشرة أو تبعية</li>
                        <li>المسؤولية تقتصر على قيمة الخدمة المقدمة فقط</li>
                        <li>لا تتحمل العيادة مسؤولية أي أضرار ناتجة عن إهمال المريض</li>
                    </ul>

                    <h3>9.2 القوة القاهرة</h3>
                    <ul>
                        <li>العيادة غير مسؤولة عن أي تأخير أو فشل في تقديم الخدمات بسبب ظروف خارجة عن إرادتها</li>
                        <li>يشمل ذلك الكوارث الطبيعية، الأوبئة، الإضرابات، أو الأحداث الطارئة</li>
                    </ul>

                    <h2>10. الشكاوى والمتابعة</h2>
                    
                    <h3>10.1 تقديم الشكاوى</h3>
                    <ul>
                        <li>يمكن تقديم الشكاوى عبر الهاتف أو البريد الإلكتروني</li>
                        <li>ستتم معالجة جميع الشكاوى خلال 48 ساعة عمل</li>
                        <li>يتم الرد على الشكوى خلال 7 أيام عمل كحد أقصى</li>
                    </ul>

                    <h3>10.2 الاسترداد</h3>
                    <ul>
                        <li>يمكن طلب الاسترداد في حالة عدم تقديم الخدمة</li>
                        <li>يتم تقييم طلبات الاسترداد على أساس فردي</li>
                        <li>قرار الاسترداد نهائي وغير قابل للطعن</li>
                    </ul>

                    <h2>11. التعديلات</h2>
                    <p>تحتفظ العيادة بالحق في تعديل هذه الشروط والأحكام في أي وقت. سيتم إشعاركم بأي تغييرات جوهرية من خلال:</p>
                    <ul>
                        <li>إشعار بارز على الموقع</li>
                        <li>إرسال إشعار عبر البريد الإلكتروني</li>
                        <li>تحديث تاريخ "آخر تحديث" في أعلى هذه الصفحة</li>
                    </ul>

                    <h2>12. القانون المعمول به</h2>
                    <p>
                        تخضع هذه الشروط والأحكام للقوانين المصرية. أي نزاع ينشأ عن استخدام خدمات العيادة سيتم حله في المحاكم المصرية المختصة.
                    </p>

                    <h2>13. معلومات التواصل</h2>
                    <p>للاستفسارات حول هذه الشروط والأحكام، يرجى التواصل معنا:</p>
                    <ul>
                        <li><strong>الهاتف:</strong> 01055558199</li>
                        <li><strong>البريد الإلكتروني:</strong> info@clinica.com</li>
                        <li><strong>العنوان:</strong> القاهرة، مصر</li>
                        <li><strong>ساعات العمل:</strong> من 9 صباحاً إلى 9 مساءً (السبت - الخميس)</li>
                    </ul>

                    <div class="bg-red-50 border border-red-200 rounded-lg p-6 mt-8">
                        <h3 class="text-red-900 font-bold mb-2">إقرار وتعهد</h3>
                        <p class="text-red-800">
                            بإتمام عملية الحجز أو استخدام خدمات عيادة د. عبد الناصر الأخرس، فإنكم تؤكدون أنكم قرأتم وفهمتم ووافقتم على جميع الشروط والأحكام المذكورة أعلاه، وتتعهدون بالالتزام بها.
                        </p>
                    </div>
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
    </script>
</body>
</html>