<x-layouts.app title="الرئيسية" description="عيادة د. عبدالناصر الأخرس - استشاري جراحات الشبكية والمياه البيضاء">
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-blue-700 via-blue-800 to-blue-900 text-white relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-20 w-72 h-72 bg-amber-400 rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
            <div class="absolute top-40 right-20 w-72 h-72 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-20 left-40 w-72 h-72 bg-purple-400 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="text-center lg:text-right rtl:text-right">
                    <h1 class="text-4xl lg:text-6xl font-bold leading-tight mb-6">
                        <span class="bg-gradient-to-r from-white to-blue-100 bg-clip-text text-transparent">
                            {{ __('عيادة د. عبدالناصر الأخرس') }}
                        </span>
                    </h1>
                    <p class="text-xl lg:text-2xl text-amber-300 mb-6 font-semibold">
                        {{ __('استشاري جراحات الشبكية والمياه البيضاء') }}
                    </p>
                    <p class="text-lg text-blue-100 mb-8 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        {{ __('أكثر من 20 عاماً من الخبرة في جراحات العيون المتقدمة. نستخدم أحدث التقنيات لضمان أفضل النتائج لمرضانا الكرام.') }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('booking') }}" 
                           class="bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white px-8 py-4 rounded-xl text-lg font-semibold transition-all duration-300 text-center shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                            {{ __('احجز موعد الآن') }}
                        </a>
                        <a href="{{ route('about') }}" 
                           class="border-2 border-white text-white px-8 py-4 rounded-xl text-lg font-semibold hover:bg-white hover:text-blue-800 transition-all duration-300 text-center">
                            {{ __('تعرف على الطبيب') }}
                        </a>
                    </div>
                </div>
                <div class="hidden lg:block relative">
                    <div class="relative z-10">
                        <img src="{{ asset('images/doctor-hero.png') }}" 
                             alt="د. عبدالناصر الأخرس" 
                             class="w-full max-w-md mx-auto rounded-2xl shadow-2xl">
                    </div>
                    
                    <!-- Floating Cards -->
                    <div class="absolute -top-4 -right-4 bg-white bg-opacity-95 backdrop-blur-sm rounded-2xl p-4 shadow-xl">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center ml-3">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900">{{ __('20+ عام') }}</h3>
                                <p class="text-xs text-gray-600">{{ __('خبرة متخصصة') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="absolute -bottom-4 -left-4 bg-white bg-opacity-95 backdrop-blur-sm rounded-2xl p-4 shadow-xl">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center ml-3">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900">{{ __('5000+') }}</h3>
                                <p class="text-xs text-gray-600">{{ __('عملية ناجحة') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-gray-900 mb-2">20+</div>
                    <div class="text-gray-600">{{ __('عام من الخبرة') }}</div>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-gray-900 mb-2">1000+</div>
                    <div class="text-gray-600">{{ __('عملية ناجحة') }}</div>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div class="text-3xl font-bold text-gray-900 mb-2">500+</div>
                    <div class="text-gray-600">{{ __('مريض سعيد') }}</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">{{ __('خدماتنا الطبية') }}</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    {{ __('نقدم مجموعة شاملة من خدمات طب وجراحة العيون باستخدام أحدث التقنيات والمعدات الطبية المتطورة') }}
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                    $services = \App\Models\Service::where('is_active', true)->take(6)->get();
                @endphp
                
                @foreach($services as $service)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow p-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            {{ $service->getTranslation('name', 'ar') }}
                        </h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            {{ $service->getTranslation('description', 'ar') }}
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-blue-600">
                                {{ $service->consultation_fee }} {{ __('جنيه') }}
                            </div>
                            <span class="text-sm text-gray-500">{{ $service->duration }} {{ __('دقيقة') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('services') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                    {{ __('عرض جميع الخدمات') }}
                </a>
            </div>
        </div>
    </section>

    <!-- About Doctor Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">
                        {{ __('د. عبدالناصر الأخرس') }}
                    </h2>
                    <h3 class="text-xl text-blue-600 font-semibold mb-6">
                        {{ __('استشاري جراحات الشبكية والمياه البيضاء') }}
                    </h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        {{ __('د. عبدالناصر الأخرس هو استشاري في جراحات الشبكية والمياه البيضاء مع أكثر من 20 عاماً من الخبرة في هذا المجال. حاصل على بكالوريوس الطب والجراحة وأخصائي طب وجراحة العيون.') }}
                    </p>
                    <div class="space-y-4 mb-8">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 ml-3 rtl:ml-0 rtl:mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">{{ __('خبرة أكثر من 20 عاماً في جراحات العيون') }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 ml-3 rtl:ml-0 rtl:mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">{{ __('أحدث التقنيات في جراحة العيون') }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 ml-3 rtl:ml-0 rtl:mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">{{ __('رعاية طبية متميزة ومعايير عالية للجودة') }}</span>
                        </div>
                    </div>
                    <a href="{{ route('about') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                        {{ __('المزيد عن الطبيب') }}
                    </a>
                </div>
                <div class="text-center">
                    <div class="relative">
                        <div class="w-80 h-80 bg-gradient-to-br from-blue-100 to-blue-200 rounded-3xl mx-auto flex items-center justify-center">
                            <div class="w-72 h-72 bg-white rounded-2xl shadow-lg flex items-center justify-center">
                                <svg class="w-32 h-32 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">{{ __('آراء مرضانا') }}</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    {{ __('ماذا يقول مرضانا عن تجربتهم معنا') }}
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php
                    $testimonials = \App\Models\Testimonial::where('is_approved', true)
                        ->where('is_featured', true)
                        ->take(3)
                        ->get();
                @endphp
                
                @foreach($testimonials as $testimonial)
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center mb-4">
                            <div class="flex text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $testimonial->rating)
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <p class="text-gray-600 mb-4 italic">"{{ $testimonial->getTranslation('content', 'ar') }}"</p>
                        <div class="border-t pt-4">
                            <div class="font-semibold text-gray-900">{{ $testimonial->getTranslation('patient_name', 'ar') }}</div>
                            <div class="text-sm text-gray-500">{{ $testimonial->getTranslation('patient_location', 'ar') }}</div>
                            <div class="text-sm text-blue-600 mt-1">{{ $testimonial->service_name }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('testimonials') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                    {{ __('عرض جميع الآراء') }}
                </a>
            </div>
        </div>
    </section>

    <!-- Contact CTA Section -->
    <section class="py-16 bg-blue-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl lg:text-4xl font-bold mb-6">
                {{ __('احجز موعدك الآن') }}
            </h2>
            <p class="text-xl text-blue-100 mb-8 max-w-3xl mx-auto">
                {{ __('احصل على أفضل رعاية طبية لعيونك مع أحدث التقنيات والخبرة المتقدمة') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('booking') }}" 
                   class="bg-white text-blue-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-blue-50 transition-colors">
                    {{ __('احجز موعد') }}
                </a>
                <a href="tel:01055558199" 
                   class="border-2 border-white text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                    {{ __('اتصل بنا الآن') }}
                </a>
            </div>
        </div>
    </section>
</x-layouts.app>