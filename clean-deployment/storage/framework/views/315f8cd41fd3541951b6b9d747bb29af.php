<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'الأسئلة الشائعة','description' => 'إجابات على أهم الأسئلة الشائعة حول خدمات وعلاج العيون في عيادة د. عبدالناصر الأخصور']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'الأسئلة الشائعة','description' => 'إجابات على أهم الأسئلة الشائعة حول خدمات وعلاج العيون في عيادة د. عبدالناصر الأخصور']); ?>

<!-- Hero Section -->
<section class="bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl lg:text-5xl font-bold mb-6">الأسئلة الشائعة</h1>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                <?php echo e(__('إجابات شاملة على أهم الأسئلة التي قد تخطر ببالك حول علاج العيون')); ?>

            </p>
        </div>
    </div>
</section>

<!-- Search FAQ -->
<section class="py-10 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative">
            <input type="text" 
                   id="faq-search"
                   placeholder="<?php echo e(__('ابحث في الأسئلة الشائعة...')); ?>"
                   class="w-full px-6 py-4 pr-12 text-lg border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-right">
            <svg class="absolute right-4 top-1/2 transform -translate-y-1/2 w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
    </div>
</section>

<!-- FAQ Categories -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- General Questions -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">أسئلة عامة</h2>
            
            <div class="space-y-6">
                
                <!-- FAQ Item 1 -->
                <div class="faq-item bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                    <button class="faq-question w-full px-6 py-4 text-right text-lg font-semibold text-gray-900 hover:bg-gray-50 transition-colors flex justify-between items-center">
                        <svg class="w-6 h-6 text-gray-500 transform transition-transform faq-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        <?php echo e(__('ما هي ساعات عمل العيادة؟')); ?>

                    </button>
                    <div class="faq-answer hidden px-6 pb-4 text-gray-700 leading-relaxed">
                        <p><?php echo e(__('نحن مفتوحون من الأحد إلى الخميس من 9:00 صباحاً إلى 6:00 مساءً، والجمعة من 9:00 صباحاً إلى 1:00 ظهراً.，我们是مغلقين أيام السبت والعطل الرسمية.')); ?></p>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="faq-item bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                    <button class="faq-question w-full px-6 py-4 text-right text-lg font-semibold text-gray-900 hover:bg-gray-50 transition-colors flex justify-between items-center">
                        <svg class="w-6 h-6 text-gray-500 transform transition-transform faq-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        <?php echo e(__('كيف يمكنني حجز موعد؟')); ?>

                    </button>
                    <div class="faq-answer hidden px-6 pb-4 text-gray-700 leading-relaxed">
                        <p><?php echo e(__('يمكنك حجز موعد بعدة طرق: 1) ملء نموذج الحجز عبر الموقع، 2) الاتصال هاتفياً على 0123456789، 3) إرسال رسالة عبر واتساب على نفس الرقم. سنقوم بتأكيد موعدك في أقرب وقت.')); ?></p>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="faq-item bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                    <button class="faq-question w-full px-6 py-4 text-right text-lg font-semibold text-gray-900 hover:bg-gray-50 transition-colors flex justify-between items-center">
                        <svg class="w-6 h-6 text-gray-500 transform transition-transform faq-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        <?php echo e(__('هل العيادة مجهزة بأحدث التقنيات؟')); ?>

                    </button>
                    <div class="faq-answer hidden px-6 pb-4 text-gray-700 leading-relaxed">
                        <p><?php echo e(__('نعم، عيادتنا مجهزة بأحدث التقنيات والأجهزة الطبية العالمية، بما في ذلك: الفاحص الضوئي المقطعي OCT، أجهزة الليزر الجراحية المتقدمة، المجاهير الجراحية الدقيقة، وكاميرات الشبكية المتطورة.')); ?></p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Water Treatment Questions -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">علاج المياه البيضاء</h2>
            
            <div class="space-y-6">
                
                <!-- FAQ Item 4 -->
                <div class="faq-item bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                    <button class="faq-question w-full px-6 py-4 text-right text-lg font-semibold text-gray-900 hover:bg-gray-50 transition-colors flex justify-between items-center">
                        <svg class="w-6 h-6 text-gray-500 transform transition-transform faq-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        <?php echo e(__('ما هي أعراض المياه البيضاء؟')); ?>

                    </button>
                    <div class="faq-answer hidden px-6 pb-4 text-gray-700 leading-relaxed">
                        <p><?php echo e(__('الأعراض تشمل: ضبابية أو عدم وضوح في الرؤية، صعوبة في القراءة أو القيادة ليلاً، حساسية للضوء، رؤية هالات حول الأضواء، الحاجة لتغيير النظارات الطبية频繁اً، وتلاشي الألوان.')); ?></p>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="faq-item bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                    <button class="faq-question w-full px-6 py-4 text-right text-lg font-semibold text-gray-900 hover:bg-gray-50 transition-colors flex justify-between items-center">
                        <svg class="w-6 h-6 text-gray-500 transform transition-transform faq-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        <?php echo e(__('كم تستغرق عملية المياه البيضاء؟')); ?>

                    </button>
                    <div class="faq-answer hidden px-6 pb-4 text-gray-700 leading-relaxed">
                        <p><?php echo e(__('عملية المياه البيضاء باستخدام تقنية الفاكو تستغرق عادة 15-30 دقيقة لكل عين. العملية تتم تحت تأثير مخدر موضعي وتعتبر من العمليات الآمنة جداً.')); ?></p>
                    </div>
                </div>

                <!-- FAQ Item 6 -->
                <div class="faq-item bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                    <button class="faq-question w-full px-6 py-4 text-right text-lg font-semibold text-gray-900 hover:bg-gray-50 transition-colors flex justify-between items-center">
                        <svg class="w-6 h-6 text-gray-500 transform transition-transform faq-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        <?php echo e(__('هل العدسات المزروعة مناسبة لكل الأعمار؟')); ?>

                    </button>
                    <div class="faq-answer hidden px-6 pb-4 text-gray-700 leading-relaxed">
                        <p><?php echo e(__('نعم، العدسات المزروعة مناسبة لمعظم الأعمار. نوع العدسة المناسبة يعتمد على احتياجاتك البصرية ونمط حياتك. هناك أنواع مختلفة من العدسات: التقليدية، المتعددة البؤر، والتوركية.')); ?></p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Retinal Treatment Questions -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">علاج الشبكية</h2>
            
            <div class="space-y-6">
                
                <!-- FAQ Item 7 -->
                <div class="faq-item bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                    <button class="faq-question w-full px-6 py-4 text-right text-lg font-semibold text-gray-900 hover:bg-gray-50 transition-colors flex justify-between items-center">
                        <svg class="w-6 h-6 text-gray-500 transform transition-transform faq-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        <?php echo e(__('ما هي أمراض الشبكية الشائعة؟')); ?>

                    </button>
                    <div class="faq-answer hidden px-6 pb-4 text-gray-700 leading-relaxed">
                        <p><?php echo e(__('أمراض الشبكية الشائعة تشمل: انفصال الشبكية، تليف الشبكية، الجلوكوما، التهاب الشبكية، اعتلال الشبكية السكري، ومرض القرص البصري. كل حالة تحتاج تشخيص دقيق وعلاج مناسب.')); ?></p>
                    </div>
                </div>

                <!-- FAQ Item 8 -->
                <div class="faq-item bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                    <button class="faq-question w-full px-6 py-4 text-right text-lg font-semibold text-gray-900 hover:bg-gray-50 transition-colors flex justify-between items-center">
                        <svg class="w-6 h-6 text-gray-500 transform transition-transform faq-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        <?php echo e(__('هل الليزر آمن لعلاج الشبكية؟')); ?>

                    </button>
                    <div class="faq-answer hidden px-6 pb-4 text-gray-700 leading-relaxed">
                        <p><?php echo e(__('نعم، علاج الليزر للشبكية آمن جداً وفعال عندما يتم تحت إشراف متخصص. الليزر يساعد في علاج تسريب الأوعية الدموية وإرتشاح الشبكية. قد تحتاج لجلسات متعددة حسب الحالة.')); ?></p>
                    </div>
                </div>

                <!-- FAQ Item 9 -->
                <div class="faq-item bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                    <button class="faq-question w-full px-6 py-4 text-right text-lg font-semibold text-gray-900 hover:bg-gray-50 transition-colors flex justify-between items-center">
                        <svg class="w-6 h-6 text-gray-500 transform transition-transform faq-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        <?php echo e(__('متى يجب إجراء عملية الشبكية؟')); ?>

                    </button>
                    <div class="faq-answer hidden px-6 pb-4 text-gray-700 leading-relaxed">
                        <p><?php echo e(__('يقرر الدكتور الحاجة للعملية حسب نوع وشدة الحالة. بعض الحالات تحتاج تدخل فوري مثل انفصال الشبكية، بينما الأخرى يمكن تأجيلها. المتابعة الدورية مهمة للكشف المبكر.')); ?></p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Appointment & Insurance Questions -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">المواعيد والتأمين</h2>
            
            <div class="space-y-6">
                
                <!-- FAQ Item 10 -->
                <div class="faq-item bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                    <button class="faq-question w-full px-6 py-4 text-right text-lg font-semibold text-gray-900 hover:bg-gray-50 transition-colors flex justify-between items-center">
                        <svg class="w-6 h-6 text-gray-500 transform transition-transform faq-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        <?php echo e(__('هل تقبلون التأمين الصحي؟')); ?>

                    </button>
                    <div class="faq-answer hidden px-6 pb-4 text-gray-700 leading-relaxed">
                        <p><?php echo e(__('نعم، نعمل مع معظم شركات التأمين الصحي السعودية. يرجى الاتصال بنا قبل موعدك للتأكد من تغطية التأمين ونوع الخدمات المشمولة.')); ?></p>
                    </div>
                </div>

                <!-- FAQ Item 11 -->
                <div class="faq-item bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                    <button class="faq-question w-full px-6 py-4 text-right text-lg font-semibold text-gray-900 hover:bg-gray-50 transition-colors flex justify-between items-center">
                        <svg class="w-6 h-6 text-gray-500 transform transition-transform faq-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        <?php echo e(__('ما هي تكلفة الفحص الأولي؟')); ?>

                    </button>
                    <div class="faq-answer hidden px-6 pb-4 text-gray-700 leading-relaxed">
                        <p><?php echo e(__('تكلفة الفحص الأولي تختلف حسب نوع الفحوصات المطلوبة. الفحص الأساسي يبدأ من 300 ريال، بينما الفحص الشامل مع الفحوصات المتقدمة قد تصل إلى 500 ريال. تواصل معنا لمعلومات أكثر دقة.')); ?></p>
                    </div>
                </div>

                <!-- FAQ Item 12 -->
                <div class="faq-item bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                    <button class="faq-question w-full px-6 py-4 text-right text-lg font-semibold text-gray-900 hover:bg-gray-50 transition-colors flex justify-between items-center">
                        <svg class="w-6 h-6 text-gray-500 transform transition-transform faq-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        <?php echo e(__('ماذا أحضر للفحص؟')); ?>

                    </button>
                    <div class="faq-answer hidden px-6 pb-4 text-gray-700 leading-relaxed">
                        <p><?php echo e(__('أحضر: رقم الهوية، قائمة الأدوية التي تتناولها، النظارات الطبية الحالية، تقارير طبية سابقة، وبطاقة التأمين (إن وجدت). تجنب قيادة السيارة بعد استخدام قطرات توسيع حدقة العين.')); ?></p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Emergency Questions -->
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">الطوارئ</h2>
            
            <div class="space-y-6">
                
                <!-- FAQ Item 13 -->
                <div class="faq-item bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                    <button class="faq-question w-full px-6 py-4 text-right text-lg font-semibold text-gray-900 hover:bg-gray-50 transition-colors flex justify-between items-center">
                        <svg class="w-6 h-6 text-gray-500 transform transition-transform faq-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        <?php echo e(__('متى أعتبر الأعراض طارئة؟')); ?>

                    </button>
                    <div class="faq-answer hidden px-6 pb-4 text-gray-700 leading-relaxed">
                        <p><?php echo e(__('اعتبر الأعراض طارئة عند: فقدان مفاجئ للبصر، ألم شديد في العين، ظهور مفاجئ لنقاط سوداء أو وميض ضوئي، رؤية هالات حول الأضواء، أو تعرض العين لإصابة. في هذه الحالات، اتصل بنا فوراً أو اذهب لأقرب مستشفى.')); ?></p>
                    </div>
                </div>

                <!-- FAQ Item 14 -->
                <div class="faq-item bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                    <button class="faq-question w-full px-6 py-4 text-right text-lg font-semibold text-gray-900 hover:bg-gray-50 transition-colors flex justify-between items-center">
                        <svg class="w-6 h-6 text-gray-500 transform transition-transform faq-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        <?php echo e(__('هل توجد خدمة طوارئ 24 ساعة؟')); ?>

                    </button>
                    <div class="faq-answer hidden px-6 pb-4 text-gray-700 leading-relaxed">
                        <p><?php echo e(__('نعم، نوفر خدمة طوارئ 24 ساعة للحالات العاجلة. يمكنك الاتصال على الرقم الموحد أو إرسال واتساب. للحالات الحرجة جداً، ننصحك بالذهاب لأقرب مستشفى مجهز للطوارئ.')); ?></p>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

<!-- Contact Support -->
<section class="py-20 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-6">لم تجد إجابة لسؤالك؟</h2>
        <p class="text-xl text-gray-600 mb-8">
            <?php echo e(__('لا تتردد في التواصل معنا للحصول على إجابة دقيقة وشخصية')); ?>

        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?php echo e(route('contact')); ?>" 
               class="bg-blue-600 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-blue-700 transition-colors">
                <?php echo e(__('تواصل معنا')); ?>

            </a>
            <a href="https://wa.me/966123456789" target="_blank"
               class="border-2 border-blue-600 text-blue-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-blue-600 hover:text-white transition-colors">
                <?php echo e(__('واتساب')); ?>

            </a>
        </div>
    </div>
</section>

<!-- FAQ Toggle Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            const faqItem = this.parentElement;
            const answer = faqItem.querySelector('.faq-answer');
            const icon = this.querySelector('.faq-icon');
            
            // Close all other FAQ items
            faqQuestions.forEach(otherQuestion => {
                if (otherQuestion !== this) {
                    const otherItem = otherQuestion.parentElement;
                    const otherAnswer = otherItem.querySelector('.faq-answer');
                    const otherIcon = otherQuestion.querySelector('.faq-icon');
                    
                    otherAnswer.classList.add('hidden');
                    otherIcon.style.transform = 'rotate(0deg)';
                }
            });
            
            // Toggle current FAQ item
            if (answer.classList.contains('hidden')) {
                answer.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                answer.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        });
    });
});
</script>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $attributes = $__attributesOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__attributesOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $component = $__componentOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__componentOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?><?php /**PATH /workspace/final-project/resources/views/pages/faq.blade.php ENDPATH**/ ?>