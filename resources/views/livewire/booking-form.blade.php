<div>
    <div class="max-w-4xl mx-auto">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        @if($success)
            <div class="mb-6 p-6 bg-green-50 border border-green-200 rounded-lg text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-green-800 mb-2">{{ __('تم حجز الموعد بنجاح!') }}</h3>
                <p class="text-green-700">{{ __('سيتم توجيهك إلى واتساب للتواصل مع العيادة وتأكيد الموعد.') }}</p>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
                <!-- Progress Steps -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                    <div class="flex items-center justify-center space-x-4 rtl:space-x-reverse">
                        <!-- Step 1: Personal Info -->
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full {{ $step >= 1 ? 'bg-white text-blue-600' : 'bg-blue-400 text-white' }} flex items-center justify-center text-sm font-semibold">
                                1
                            </div>
                            <span class="mr-2 rtl:mr-0 rtl:ml-2 text-white text-sm font-medium hidden sm:inline">المعلومات الشخصية</span>
                        </div>
                        
                        <div class="w-12 h-1 {{ $step >= 2 ? 'bg-amber-400' : 'bg-blue-400' }} rounded"></div>
                        
                        <!-- Step 2: Service Selection -->
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full {{ $step >= 2 ? 'bg-white text-blue-600' : 'bg-blue-400 text-white' }} flex items-center justify-center text-sm font-semibold">
                                2
                            </div>
                            <span class="mr-2 rtl:mr-0 rtl:ml-2 text-white text-sm font-medium hidden sm:inline">اختيار الخدمة</span>
                        </div>
                        
                        <div class="w-12 h-1 {{ $step >= 3 ? 'bg-amber-400' : 'bg-blue-400' }} rounded"></div>
                        
                        <!-- Step 3: Date & Time -->
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full {{ $step >= 3 ? 'bg-white text-blue-600' : 'bg-blue-400 text-white' }} flex items-center justify-center text-sm font-semibold">
                                3
                            </div>
                            <span class="mr-2 rtl:mr-0 rtl:ml-2 text-white text-sm font-medium hidden sm:inline">التاريخ والوقت</span>
                        </div>
                        
                        <div class="w-12 h-1 {{ $step >= 4 ? 'bg-amber-400' : 'bg-blue-400' }} rounded"></div>
                        
                        <!-- Step 4: Confirmation -->
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full {{ $step >= 4 ? 'bg-white text-blue-600' : 'bg-blue-400 text-white' }} flex items-center justify-center text-sm font-semibold">
                                4
                            </div>
                            <span class="mr-2 rtl:mr-0 rtl:ml-2 text-white text-sm font-medium hidden sm:inline">التأكيد</span>
                        </div>
                    </div>
                </div>

                <form wire:submit="submit" class="space-y-6 p-6">
                    <div class="bg-gray-50 rounded-lg p-6">
                        <!-- Step 1: Personal Information -->
                        @if($step >= 1)
                            <div class="{{ $step == 1 ? 'block' : ($step > 1 ? 'animate-fadeIn' : 'hidden') }}">
                                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                    <svg class="w-6 h-6 text-blue-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                    </svg>
                                    المعلومات الشخصية
                                </h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="patientName" class="block text-sm font-medium text-gray-700 mb-2">
                                            {{ __('اسم المريض الكامل') }} <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" 
                                               id="patientName"
                                               wire:model="patientName"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                               placeholder="{{ __('أدخل الاسم كاملاً') }}">
                                        @error('patientName')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="patientPhone" class="block text-sm font-medium text-gray-700 mb-2">
                                            {{ __('رقم الهاتف') }} <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <input type="tel" 
                                                   id="patientPhone"
                                                   wire:model.live="patientPhone"
                                                   class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                                   placeholder="0501234567">
                                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                            </svg>
                                        </div>
                                        @error('patientPhone')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <label for="patientEmail" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('البريد الإلكتروني') }} <span class="text-gray-500">(اختياري)</span>
                                    </label>
                                    <div class="relative">
                                        <input type="email" 
                                               id="patientEmail"
                                               wire:model="patientEmail"
                                               class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                               placeholder="example@email.com">
                                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                        </svg>
                                    </div>
                                    @error('patientEmail')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        <!-- Step 2: Service Selection -->
                        @if($step >= 2)
                            <div class="{{ $step == 2 ? 'block' : ($step > 2 ? 'animate-fadeIn' : 'hidden') }}">
                                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                    <svg class="w-6 h-6 text-blue-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    اختيار الخدمة
                                </h3>
                                
                                <div class="space-y-4">
                                    @foreach($services as $service)
                                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-all cursor-pointer {{ $serviceId == $service->id ? 'border-blue-500 bg-blue-50' : '' }}">
                                            <input type="radio" 
                                                   wire:model="serviceId"
                                                   value="{{ $service->id }}"
                                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                            <div class="mr-3 rtl:mr-0 rtl:ml-3 flex-1">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <h4 class="text-lg font-semibold text-gray-900">{{ $service->getTranslation('name', 'ar') }}</h4>
                                                        <p class="text-sm text-gray-600 mt-1">{{ $service->getTranslation('description', 'ar') }}</p>
                                                        <div class="flex items-center mt-2">
                                                            <svg class="w-4 h-4 text-green-500 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                                            </svg>
                                                            <span class="text-sm text-green-600 font-medium">متوفر</span>
                                                        </div>
                                                    </div>
                                                    <div class="text-left rtl:text-right">
                                                        <span class="text-xl font-bold text-blue-600">{{ $service->consultation_fee }}</span>
                                                        <span class="text-sm text-gray-500 block">ريال سعودي</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                
                                @error('serviceId')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <!-- Step 3: Date & Time -->
                        @if($step >= 3)
                            <div class="{{ $step == 3 ? 'block' : ($step > 3 ? 'animate-fadeIn' : 'hidden') }}">
                                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                    <svg class="w-6 h-6 text-blue-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                    </svg>
                                    التاريخ والوقت
                                </h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="appointmentDate" class="block text-sm font-medium text-gray-700 mb-2">
                                            {{ __('تاريخ الموعد') }} <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <input type="date" 
                                                   id="appointmentDate"
                                                   wire:model="appointmentDate"
                                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                                   class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        @error('appointmentDate')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="appointmentTime" class="block text-sm font-medium text-gray-700 mb-2">
                                            {{ __('وقت الموعد') }} <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <select id="appointmentTime"
                                                    wire:model="appointmentTime"
                                                    class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                                <option value="">{{ __('اختر الوقت المناسب') }}</option>
                                                @foreach($timeSlots as $slot)
                                                    <option value="{{ $slot }}">{{ \Carbon\Carbon::parse($slot)->format('h:i A') }}</option>
                                                @endforeach
                                            </select>
                                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        @error('appointmentTime')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('ملاحظات إضافية') }} <span class="text-gray-500">(اختياري)</span>
                                    </label>
                                    <textarea id="notes"
                                              wire:model="notes"
                                              rows="4"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                              placeholder="{{ __('وصف الأعراض أو أي معلومات إضافية تريد مشاركتها مع الطبيب...') }}"></textarea>
                                    @error('notes')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        <!-- Step 4: Confirmation -->
                        @if($step >= 4)
                            <div class="{{ $step == 4 ? 'block' : ($step > 4 ? 'animate-fadeIn' : 'hidden') }}">
                                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                    <svg class="w-6 h-6 text-blue-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    مراجعة وتأكيد الحجز
                                </h3>
                                
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                                    <h4 class="text-lg font-semibold text-blue-900 mb-4">مراجعة تفاصيل الحجز</h4>
                                    
                                    <div class="space-y-3 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-blue-700">اسم المريض:</span>
                                            <span class="font-semibold text-blue-900">{{ $patientName }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-blue-700">رقم الهاتف:</span>
                                            <span class="font-semibold text-blue-900">{{ $patientPhone }}</span>
                                        </div>
                                        @if($patientEmail)
                                        <div class="flex justify-between">
                                            <span class="text-blue-700">البريد الإلكتروني:</span>
                                            <span class="font-semibold text-blue-900">{{ $patientEmail }}</span>
                                        </div>
                                        @endif
                                        <div class="flex justify-between">
                                            <span class="text-blue-700">الخدمة:</span>
                                            <span class="font-semibold text-blue-900">
                                                @if($serviceId)
                                                    @php $selectedService = $services->find($serviceId); @endphp
                                                    {{ $selectedService ? $selectedService->getTranslation('name', 'ar') : '' }}
                                                @endif
                                            </span>
                                        </div>
                                        @if($appointmentDate)
                                        <div class="flex justify-between">
                                            <span class="text-blue-700">التاريخ:</span>
                                            <span class="font-semibold text-blue-900">
                                                {{ \Carbon\Carbon::parse($appointmentDate)->locale('ar')->translatedFormat('l، d F Y') }}
                                            </span>
                                        </div>
                                        @endif
                                        @if($appointmentTime)
                                        <div class="flex justify-between">
                                            <span class="text-blue-700">الوقت:</span>
                                            <span class="font-semibold text-blue-900">{{ \Carbon\Carbon::parse($appointmentTime)->format('h:i A') }}</span>
                                        </div>
                                        @endif
                                        @if($selectedService)
                                        <div class="flex justify-between border-t border-blue-300 pt-3">
                                            <span class="text-blue-700">تكلفة الاستشارة:</span>
                                            <span class="font-bold text-blue-900 text-lg">{{ $selectedService->consultation_fee }} ريال</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Terms and Conditions -->
                                <div class="mb-6">
                                    <label class="flex items-start">
                                        <input type="checkbox" 
                                               wire:model="termsAccepted"
                                               class="mt-1 h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        <span class="mr-3 rtl:mr-0 rtl:ml-3 text-sm text-gray-700">
                                            {{ __('أوافق على') }}
                                            <a href="#" class="text-blue-600 hover:text-blue-800 underline">{{ __('الشروط والأحكام') }}</a>
                                            {{ __('و') }}
                                            <a href="#" class="text-blue-600 hover:text-blue-800 underline">{{ __('سياسة الخصوصية') }}</a>
                                            <span class="text-red-500">*</span>
                                        </span>
                                    </label>
                                    @error('termsAccepted')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                        <div>
                            @if($step > 1)
                                <button type="button" 
                                        wire:click="previousStep"
                                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                    السابق
                                </button>
                            @endif
                        </div>
                        
                        <div>
                            @if($step < 4)
                                <button type="button" 
                                        wire:click="nextStep"
                                        class="px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg">
                                    التالي
                                </button>
                            @else
                                <button type="submit" 
                                        wire:loading.attr="disabled"
                                        class="px-8 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-lg transition-all shadow-lg disabled:opacity-50">
                                    <span wire:loading.remove>تأكيد الحجز</span>
                                    <span wire:loading class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        جارٍ الحفظ...
                                    </span>
                                </button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        @endif

        <!-- Additional Information -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="mr-3 rtl:mr-0 rtl:ml-3">
                    <h3 class="text-lg font-medium text-blue-900 mb-2">{{ __('معلومات مهمة') }}</h3>
                    <ul class="text-sm text-blue-800 space-y-2">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 ml-2 rtl:ml-0 rtl:mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('سيتم إرسال تفاصيل الموعد عبر واتساب لتأكيد الحجز') }}
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 ml-2 rtl:ml-0 rtl:mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('يرجى الوصول قبل الموعد بـ 15 دقيقة') }}
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 ml-2 rtl:ml-0 rtl:mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('يمكن إلغاء أو تعديل الموعد عبر التواصل مع العيادة') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>