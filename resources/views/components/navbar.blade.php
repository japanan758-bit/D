<nav x-data="{ isOpen: false }" class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center">
                    <div class="flex items-center">
                        <img src="{{ asset('images/logo-main.jpg') }}" alt="شعار العيادة" class="h-12 w-auto ml-2">
                        <div class="mr-3">
                            <div class="text-lg font-bold text-blue-900">{{ config('app.name', 'عيادة د. عبدالناصر الأخرس') }}</div>
                            <div class="text-xs text-amber-600 font-semibold">{{ __('استشاري جراحات الشبكية والمياه البيضاء') }}</div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:block">
                <div class="mr-10 flex items-baseline space-x-4 rtl:space-x-reverse">
                    <a href="{{ route('home') }}" 
                       class="text-gray-900 hover:bg-blue-50 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-600' : '' }}">
                        {{ __('الرئيسية') }}
                    </a>
                    <a href="{{ route('about') }}" 
                       class="text-gray-700 hover:bg-blue-50 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('about') ? 'bg-blue-50 text-blue-600' : '' }}">
                        {{ __('نبذة عن الطبيب') }}
                    </a>
                    <a href="{{ route('services') }}" 
                       class="text-gray-700 hover:bg-blue-50 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('services') ? 'bg-blue-50 text-blue-600' : '' }}">
                        {{ __('خدماتنا') }}
                    </a>
                    <a href="{{ route('articles') }}" 
                       class="text-gray-700 hover:bg-blue-50 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('articles') ? 'bg-blue-50 text-blue-600' : '' }}">
                        {{ __('مقالات طبية') }}
                    </a>
                    <a href="{{ route('testimonials') }}" 
                       class="text-gray-700 hover:bg-blue-50 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('testimonials') ? 'bg-blue-50 text-blue-600' : '' }}">
                        {{ __('آراء المرضى') }}
                    </a>
                    <a href="{{ route('faq') }}" 
                       class="text-gray-700 hover:bg-blue-50 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('faq') ? 'bg-blue-50 text-blue-600' : '' }}">
                        {{ __('أسئلة شائعة') }}
                    </a>
                    <a href="{{ route('contact') }}" 
                       class="text-gray-700 hover:bg-blue-50 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('contact') ? 'bg-blue-50 text-blue-600' : '' }}">
                        {{ __('تواصل معنا') }}
                    </a>
                </div>
            </div>

            <!-- CTA Button -->
            <div class="hidden md:block">
                <a href="{{ route('booking') }}" 
                   class="bg-gradient-to-r from-blue-700 to-amber-600 hover:from-blue-800 hover:to-amber-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    {{ __('احجز موعد') }}
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button @click="isOpen = !isOpen" 
                        class="bg-gray-100 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500"
                        aria-expanded="false">
                    <span class="sr-only">{{ __('فتح القائمة') }}</span>
                    <!-- Menu icon -->
                    <svg x-show="!isOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!-- Close icon -->
                    <svg x-show="isOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-100 transform"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75 transform"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white shadow-lg">
            <a href="{{ route('home') }}" 
               class="text-gray-900 hover:bg-blue-50 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-600' : '' }}">
                {{ __('الرئيسية') }}
            </a>
            <a href="{{ route('about') }}" 
               class="text-gray-700 hover:bg-blue-50 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('about') ? 'bg-blue-50 text-blue-600' : '' }}">
                {{ __('نبذة عن الطبيب') }}
            </a>
            <a href="{{ route('services') }}" 
               class="text-gray-700 hover:bg-blue-50 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('services') ? 'bg-blue-50 text-blue-600' : '' }}">
                {{ __('خدماتنا') }}
            </a>
            <a href="{{ route('articles') }}" 
               class="text-gray-700 hover:bg-blue-50 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('articles') ? 'bg-blue-50 text-blue-600' : '' }}">
                {{ __('مقالات طبية') }}
            </a>
            <a href="{{ route('testimonials') }}" 
               class="text-gray-700 hover:bg-blue-50 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('testimonials') ? 'bg-blue-50 text-blue-600' : '' }}">
                {{ __('آراء المرضى') }}
            </a>
            <a href="{{ route('faq') }}" 
               class="text-gray-700 hover:bg-blue-50 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('faq') ? 'bg-blue-50 text-blue-600' : '' }}">
                {{ __('أسئلة شائعة') }}
            </a>
            <a href="{{ route('contact') }}" 
               class="text-gray-700 hover:bg-blue-50 hover:text-blue-600 block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('contact') ? 'bg-blue-50 text-blue-600' : '' }}">
                {{ __('تواصل معنا') }}
            </a>
            
            <!-- Mobile CTA -->
            <div class="pt-4">
                <a href="{{ route('booking') }}" 
                   class="w-full bg-gradient-to-r from-blue-700 to-amber-600 hover:from-blue-800 hover:to-amber-700 text-white px-4 py-2 rounded-lg text-base font-medium text-center block transition-all duration-300 shadow-lg">
                    {{ __('احجز موعد') }}
                </a>
            </div>
        </div>
    </div>
</nav>