<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'آراء المرضى','description' => 'تعرف على تجارب وآراء مرضانا الكرام في عيادة د. عبدالناصر الأخصور']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'آراء المرضى','description' => 'تعرف على تجارب وآراء مرضانا الكرام في عيادة د. عبدالناصر الأخصور']); ?>

<!-- Hero Section -->
<section class="bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl lg:text-5xl font-bold mb-6">آراء المرضى</h1>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                <?php echo e(__('تعرف على تجارب مرضانا الكرام ونتائج العلاج التي حققوها مع د. عبدالناصر الأخصور')); ?>

            </p>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            
            <!-- Rating -->
            <div class="text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2">4.9/5</h3>
                <p class="text-gray-600"><?php echo e(__('متوسط التقييم')); ?></p>
                <div class="flex justify-center mt-2">
                    <span class="text-yellow-400">★★★★★</span>
                </div>
            </div>

            <!-- Total Reviews -->
            <div class="text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-600 to-blue-700 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                    </svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2">500+</h3>
                <p class="text-gray-600"><?php echo e(__('تقييم من المرضى')); ?></p>
            </div>

            <!-- Happy Patients -->
            <div class="text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-green-600 to-green-700 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                    </svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2">98%</h3>
                <p class="text-gray-600"><?php echo e(__('رضا المرضى')); ?></p>
            </div>

            <!-- Years Experience -->
            <div class="text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-600 to-purple-700 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2">20+</h3>
                <p class="text-gray-600"><?php echo e(__('عام خبرة')); ?></p>
            </div>

        </div>
    </div>
</section>

<!-- Testimonials Grid -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">ماذا يقول مرضانا</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                <?php echo e(__('تجارب حقيقية من مرضانا الكرام الذين خضعوا للعلاج في عيادتنا')); ?>

            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- Testimonial 1 -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 shadow-lg">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 rounded-full flex items-center justify-center ml-4">
                        <span class="text-white font-bold text-lg">أ</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">أحمد محمد</h4>
                        <div class="flex text-yellow-400">
                            <span>★★★★★</span>
                        </div>
                    </div>
                </div>
                <p class="text-gray-700 mb-4">
                    "<?php echo e(__('د. عبدالناصر طبيب ممتاز جداً، كان تشخيصه دقيقاً وعلاجي للمياه البيضاء مذهل. الآن أرى بوضوح تام!')); ?>"
                </p>
                <div class="flex items-center text-sm text-gray-500">
                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    منذ شهرين
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 shadow-lg">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-600 to-green-700 rounded-full flex items-center justify-center ml-4">
                        <span class="text-white font-bold text-lg">س</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">سارة أحمد</h4>
                        <div class="flex text-yellow-400">
                            <span>★★★★★</span>
                        </div>
                    </div>
                </div>
                <p class="text-gray-700 mb-4">
                    "<?php echo e(__('أطفالنا الثلاثة عندهم حول، والآن بعد جراحة د. عبدالناصر أصبح بصرهم طبيعياً تماماً. شكراً لك دكتور!')); ?>"
                </p>
                <div class="flex items-center text-sm text-gray-500">
                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    منذ 3 أشهر
                </div>
            </div>

            <!-- Testimonial 3 -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 shadow-lg">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-purple-700 rounded-full flex items-center justify-center ml-4">
                        <span class="text-white font-bold text-lg">ع</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">علي حسن</h4>
                        <div class="flex text-yellow-400">
                            <span>★★★★★</span>
                        </div>
                    </div>
                </div>
                <p class="text-gray-700 mb-4">
                    "<?php echo e(__('كنت أعاني من مشاكل في الشبكية، والآن بعد العلاج بالليزر مع د. عبدالناصر تحسنت رؤيتي كثيراً. врач ممتاز!')); ?>"
                </p>
                <div class="flex items-center text-sm text-gray-500">
                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    منذ شهر
                </div>
            </div>

            <!-- Testimonial 4 -->
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-6 shadow-lg">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-orange-600 to-orange-700 rounded-full flex items-center justify-center ml-4">
                        <span class="text-white font-bold text-lg">ف</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">فاطمة علي</h4>
                        <div class="flex text-yellow-400">
                            <span>★★★★★</span>
                        </div>
                    </div>
                </div>
                <p class="text-gray-700 mb-4">
                    "<?php echo e(__('العيادة نظيفة جداً والطاقم الطبي محترف. د. عبدالناصر شرح لي العلاج بوضوح وكنت مطمئنة طوال الوقت.')); ?>"
                </p>
                <div class="flex items-center text-sm text-gray-500">
                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    منذ أسبوعين
                </div>
            </div>

            <!-- Testimonial 5 -->
            <div class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-xl p-6 shadow-lg">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-pink-600 to-pink-700 rounded-full flex items-center justify-center ml-4">
                        <span class="text-white font-bold text-lg">خ</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">خالد سعد</h4>
                        <div class="flex text-yellow-400">
                            <span>★★★★★</span>
                        </div>
                    </div>
                </div>
                <p class="text-gray-700 mb-4">
                    "<?php echo e(__('أخيراً وجدت دكتور يفهم حالتي! علاج الجلوكوما تم بنجاح ونصحني د. عبدالناصر بالعناية المستمرة.')); ?>"
                </p>
                <div class="flex items-center text-sm text-gray-500">
                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    منذ 5 أشهر
                </div>
            </div>

            <!-- Testimonial 6 -->
            <div class="bg-gradient-to-br from-teal-50 to-teal-100 rounded-xl p-6 shadow-lg">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-teal-600 to-teal-700 rounded-full flex items-center justify-center ml-4">
                        <span class="text-white font-bold text-lg">م</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">مريم عبدالرحمن</h4>
                        <div class="flex text-yellow-400">
                            <span>★★★★★</span>
                        </div>
                    </div>
                </div>
                <p class="text-gray-700 mb-4">
                    "<?php echo e(__('كنت خائفة جداً من العملية، لكن د. عبدالناصر طمأنني وشرح كل شيء بالتفصيل. العملية تمت بنجاح تام!')); ?>"
                </p>
                <div class="flex items-center text-sm text-gray-500">
                    <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    منذ 4 أشهر
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Before & After Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">نتائج قبل وبعد</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                <?php echo e(__('أمثلة حقيقية على نتائج علاج مرضانا الكرام')); ?>

            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Case 1 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-4">
                    <h3 class="text-xl font-bold"><?php echo e(__('جراحة المياه البيضاء')); ?></h3>
                    <p class="text-blue-100">مريضة 68 عام</p>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <h4 class="font-semibold text-red-800 mb-2">قبل العلاج</h4>
                            <ul class="text-sm text-red-700 space-y-1">
                                <li>• ضعف في الرؤية بنسبة 70%</li>
                                <li>• صعوبة في القراءة</li>
                                <li>• ضبابية في الألوان</li>
                            </ul>
                        </div>
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <h4 class="font-semibold text-green-800 mb-2">بعد العلاج</h4>
                            <ul class="text-sm text-green-700 space-y-1">
                                <li>• رؤية ممتازة 95%</li>
                                <li>• قراءة طبيعية</li>
                                <li>• ألوان واضحة</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Case 2 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-green-700 text-white p-4">
                    <h3 class="text-xl font-bold"><?php echo e(__('علاج الحول')); ?></h3>
                    <p class="text-green-100">طفل 6 سنوات</p>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <h4 class="font-semibold text-red-800 mb-2">قبل العلاج</h4>
                            <ul class="text-sm text-red-700 space-y-1">
                                <li>• حول داخلي واضح</li>
                                <li>• كسل في العين اليسرى</li>
                                <li>• صعوبة في التركيز</li>
                            </ul>
                        </div>
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <h4 class="font-semibold text-green-800 mb-2">بعد العلاج</h4>
                            <ul class="text-sm text-green-700 space-y-1">
                                <li>• عيون متوافقة 100%</li>
                                <li>• تحسين الرؤية</li>
                                <li>• تركيز طبيعي</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Case 3 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 text-white p-4">
                    <h3 class="text-xl font-bold"><?php echo e(__('علاج الجلوكوما')); ?></h3>
                    <p class="text-purple-100">مريض 55 عام</p>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <h4 class="font-semibold text-red-800 mb-2">قبل العلاج</h4>
                            <ul class="text-sm text-red-700 space-y-1">
                                <li>• ضغط عين مرتفع</li>
                                <li>• تضييق في مجال الرؤية</li>
                                <li>• آلام متكررة</li>
                            </ul>
                        </div>
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <h4 class="font-semibold text-green-800 mb-2">بعد العلاج</h4>
                            <ul class="text-sm text-green-700 space-y-1">
                                <li>• ضغط طبيعي ومستقر</li>
                                <li>• تحسين مجال الرؤية</li>
                                <li>• عدم وجود آلام</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Video Testimonials -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">شهادات بالفيديو</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                <?php echo e(__('استمع إلى شهادات مرضانا مباشرة')); ?>

            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Video Placeholder 1 -->
            <div class="bg-gray-200 rounded-xl aspect-video flex items-center justify-center">
                <div class="text-center text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                    </svg>
                    <p>شهادة مريض - جراحة الشبكية</p>
                </div>
            </div>

            <!-- Video Placeholder 2 -->
            <div class="bg-gray-200 rounded-xl aspect-video flex items-center justify-center">
                <div class="text-center text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                    </svg>
                    <p>شهادة مريض - علاج المياه البيضاء</p>
                </div>
            </div>

            <!-- Video Placeholder 3 -->
            <div class="bg-gray-200 rounded-xl aspect-video flex items-center justify-center">
                <div class="text-center text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                    </svg>
                    <p>شهادة مريض - علاج الجلوكوما</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-blue-700 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold mb-6"><?php echo e(__('كن أحد مرضانا الراضين')); ?></h2>
        <p class="text-xl text-blue-100 mb-8">
            <?php echo e(__('انضم إلى قائمة مرضانا الذين حصلوا على أفضل رعاية طبية وحققوا نتائج مذهلة')); ?>

        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?php echo e(route('booking')); ?>" 
               class="bg-white text-blue-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-blue-50 transition-colors">
                <?php echo e(__('احجز موعد الآن')); ?>

            </a>
            <a href="<?php echo e(route('contact')); ?>" 
               class="border-2 border-white text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                <?php echo e(__('اسأل سؤال')); ?>

            </a>
        </div>
    </div>
</section>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $attributes = $__attributesOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__attributesOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $component = $__componentOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__componentOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?><?php /**PATH /workspace/final-project/resources/views/pages/testimonials.blade.php ENDPATH**/ ?>