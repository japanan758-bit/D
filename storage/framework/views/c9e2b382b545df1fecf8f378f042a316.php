<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e($title ?? config('app.name')); ?></title>
    <meta name="description" content="<?php echo e($description ?? 'عيادة د. عبدالناصر الأخرس - استشاري جراحات الشبكية والمياه البيضاء'); ?>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <!-- Custom Styles -->
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-50">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="<?php echo e(route('home')); ?>" class="text-2xl font-bold text-blue-600 hover:text-blue-700 transition-colors">
                            <?php echo e(config('app.name')); ?>

                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden md:flex items-center space-x-8 space-x-reverse">
                        <a href="<?php echo e(route('home')); ?>" class="text-gray-700 hover:text-blue-600 transition-colors font-medium">
                            <?php echo e(__('الرئيسية')); ?>

                        </a>
                        <a href="<?php echo e(route('about')); ?>" class="text-gray-700 hover:text-blue-600 transition-colors font-medium">
                            <?php echo e(__('عن العيادة')); ?>

                        </a>
                        <a href="<?php echo e(route('services')); ?>" class="text-gray-700 hover:text-blue-600 transition-colors font-medium">
                            <?php echo e(__('خدماتنا')); ?>

                        </a>
                        <a href="<?php echo e(route('booking')); ?>" class="text-gray-700 hover:text-blue-600 transition-colors font-medium">
                            <?php echo e(__('احجز موعد')); ?>

                        </a>
                        <a href="<?php echo e(route('contact')); ?>" class="text-gray-700 hover:text-blue-600 transition-colors font-medium">
                            <?php echo e(__('اتصل بنا')); ?>

                        </a>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button type="button" class="text-gray-700 hover:text-blue-600" onclick="toggleMobileMenu()">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile menu -->
                <div class="md:hidden hidden" id="mobile-menu">
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                        <a href="<?php echo e(route('home')); ?>" class="block px-3 py-2 text-gray-700 hover:text-blue-600 transition-colors">
                            <?php echo e(__('الرئيسية')); ?>

                        </a>
                        <a href="<?php echo e(route('about')); ?>" class="block px-3 py-2 text-gray-700 hover:text-blue-600 transition-colors">
                            <?php echo e(__('عن العيادة')); ?>

                        </a>
                        <a href="<?php echo e(route('services')); ?>" class="block px-3 py-2 text-gray-700 hover:text-blue-600 transition-colors">
                            <?php echo e(__('خدماتنا')); ?>

                        </a>
                        <a href="<?php echo e(route('booking')); ?>" class="block px-3 py-2 text-gray-700 hover:text-blue-600 transition-colors">
                            <?php echo e(__('احجز موعد')); ?>

                        </a>
                        <a href="<?php echo e(route('contact')); ?>" class="block px-3 py-2 text-gray-700 hover:text-blue-600 transition-colors">
                            <?php echo e(__('اتصل بنا')); ?>

                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1">
            <?php echo e($slot); ?>

        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Company Info -->
                    <div>
                        <h3 class="text-xl font-bold mb-4"><?php echo e(config('app.name')); ?></h3>
                        <p class="text-gray-300 mb-4">
                            <?php echo e(__('عيادة د. عبدالناصر الأخرس - استشاري جراحات الشبكية والمياه البيضاء')); ?>

                        </p>
                        <p class="text-gray-300">
                            <?php echo e(__('أكثر من 20 عاماً من الخبرة في جراحات العيون المتقدمة')); ?>

                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-xl font-bold mb-4"><?php echo e(__('روابط سريعة')); ?></h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="<?php echo e(route('about')); ?>" class="text-gray-300 hover:text-white transition-colors">
                                    <?php echo e(__('عن العيادة')); ?>

                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('services')); ?>" class="text-gray-300 hover:text-white transition-colors">
                                    <?php echo e(__('خدماتنا')); ?>

                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('booking')); ?>" class="text-gray-300 hover:text-white transition-colors">
                                    <?php echo e(__('احجز موعد')); ?>

                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('contact')); ?>" class="text-gray-300 hover:text-white transition-colors">
                                    <?php echo e(__('اتصل بنا')); ?>

                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h3 class="text-xl font-bold mb-4"><?php echo e(__('معلومات التواصل')); ?></h3>
                        <div class="space-y-2 text-gray-300">
                            <p><?php echo e(__('العنوان: الرياض، المملكة العربية السعودية')); ?></p>
                            <p><?php echo e(__('الهاتف: +966-50-000-0000')); ?></p>
                            <p><?php echo e(__('البريد الإلكتروني: info@clinic.com')); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Bottom Footer -->
                <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
                    <p>&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. <?php echo e(__('جميع الحقوق محفوظة')); ?></p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH /workspace/final-project/resources/views/components/layouts/app.blade.php ENDPATH**/ ?>