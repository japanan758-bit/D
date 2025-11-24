<x-layouts.app title="اتصل بنا" description="تواصل مع عيادة د. عبدالناصر الأخصور لحجز موعد أو الاستفسار عن خدماتنا">

<!-- Hero Section -->
<section class="bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl lg:text-5xl font-bold mb-6">اتصل بنا</h1>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                {{ __('نحن هنا لمساعدتك - تواصل معنا لحجز موعد أو للاستفسار عن خدماتنا') }}
            </p>
        </div>
    </div>
</section>

<!-- Contact Information -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            
            <!-- Contact Info -->
            <div class="space-y-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">معلومات التواصل</h2>
                    <p class="text-gray-600 text-lg mb-8">
                        {{ __('نحن متاحون للرد على استفساراتكم وحجز المواعيد من الأحد إلى الخميس، 9 صباحاً إلى 6 مساءً') }}
                    </p>
                </div>

                <!-- Contact Methods -->
                <div class="space-y-6">
                    
                    <!-- Phone -->
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-600 to-green-700 rounded-full flex items-center justify-center ml-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">الهاتف</h3>
                            <p class="text-gray-600 mb-2">لحجز المواعيد والاستفسارات</p>
                            <a href="tel:+966123456789" class="text-blue-600 hover:text-blue-700 font-semibold text-lg">
                                +966 12 345 6789
                            </a>
                        </div>
                    </div>

                    <!-- WhatsApp -->
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center ml-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.386"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">واتساب</h3>
                            <p class="text-gray-600 mb-2">للرد السريع على استفساراتكم</p>
                            <a href="https://wa.me/966123456789" target="_blank" class="text-green-600 hover:text-green-700 font-semibold text-lg">
                                +966 12 345 6789
                            </a>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 rounded-full flex items-center justify-center ml-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">البريد الإلكتروني</h3>
                            <p class="text-gray-600 mb-2">للاستفسارات الرسمية</p>
                            <a href="mailto:info@clinic.com" class="text-blue-600 hover:text-blue-700 font-semibold">
                                info@clinic.com
                            </a>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-purple-700 rounded-full flex items-center justify-center ml-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">العنوان</h3>
                            <p class="text-gray-600 mb-2">موقع العيادة</p>
                            <p class="text-gray-700">
                                شارع الملك فهد، حي العليا<br>
                                الرياض 11564، المملكة العربية السعودية
                            </p>
                        </div>
                    </div>

                </div>

                <!-- Working Hours -->
                <div class="bg-white rounded-xl p-6 shadow-lg">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">ساعات العمل</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">الأحد - الخميس</span>
                            <span class="font-semibold text-gray-900">9:00 ص - 6:00 م</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">الجمعة</span>
                            <span class="font-semibold text-gray-900">9:00 ص - 1:00 م</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">السبت</span>
                            <span class="font-semibold text-red-600">مغلق</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Contact Form -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">أرسل لنا رسالة</h2>
                
                <form class="space-y-6" action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('الاسم الكامل') }} *
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-right"
                               placeholder="{{ __('أدخل اسمك الكامل') }}">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('البريد الإلكتروني') }} *
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-right"
                               placeholder="{{ __('example@email.com') }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('رقم الهاتف') }}
                        </label>
                        <input type="tel" 
                               id="phone" 
                               name="phone"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-right"
                               placeholder="{{ __('+966 50 123 4567') }}">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('موضوع الرسالة') }}
                        </label>
                        <select id="subject" 
                                name="subject"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-right">
                            <option value="">{{ __('اختر موضوع الرسالة') }}</option>
                            <option value="appointment">{{ __('حجز موعد') }}</option>
                            <option value="inquiry">{{ __('استفسار عام') }}</option>
                            <option value="treatment">{{ __('استفسار عن علاج') }}</option>
                            <option value="complaint">{{ __('شكوى') }}</option>
                            <option value="other">{{ __('أخرى') }}</option>
                        </select>
                        @error('subject')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('الرسالة') }} *
                        </label>
                        <textarea id="message" 
                                  name="message" 
                                  rows="5" 
                                  required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-right"
                                  placeholder="{{ __('اكتب رسالتك هنا...') }}"></textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 px-6 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-800 transition-colors">
                        {{ __('إرسال الرسالة') }}
                    </button>
                </form>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="mt-4 bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                            </svg>
                            <p class="text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

            </div>

        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">موقع العيادة</h2>
            <p class="text-gray-600">{{ __('يمكنك العثور على العيادة بسهولة عبر الخريطة التفاعلية التالية') }}</p>
        </div>
        
        <!-- Interactive Google Map -->
        <div class="relative rounded-xl overflow-hidden shadow-2xl">
            <div id="google-map" class="w-full h-96 bg-gray-200 rounded-xl flex items-center justify-center">
                <div class="text-center text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 animate-bounce" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-lg">جاري تحميل الخريطة...</p>
                    <p class="text-sm">شارع الملك فهد، حي العليا، الرياض</p>
                </div>
            </div>
            
            <!-- Loading indicator -->
            <div id="map-loading" class="absolute inset-0 bg-gray-100 bg-opacity-75 flex items-center justify-center rounded-xl">
                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                    <span class="text-gray-600">جاري تحميل خريطة جوجل...</span>
                </div>
            </div>
        </div>
        
        <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="https://goo.gl/maps/24.7136,46.6753" 
               target="_blank"
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                </svg>
                {{ __('فتح في خرائط جوجل') }}
            </a>
            
            <a href="https://waze.com/ul/hw23b8f7k4" 
               target="_blank"
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-300 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
                {{ __('فتح في Waze') }}
            </a>
        </div>
        
        <!-- Location Details -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center ml-4">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">العنوان الدقيق</h3>
                </div>
                <p class="text-gray-700 leading-relaxed">
                    شارع الملك فهد، حي العليا<br>
                    الرياض 11564، المملكة العربية السعودية
                </p>
            </div>
            
            <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center ml-4">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">الهاتف المباشر</h3>
                </div>
                <p class="text-gray-700">
                    <a href="tel:+966112345678" class="text-green-600 hover:text-green-700 font-semibold">
                        +966 11 234 5678
                    </a>
                </p>
            </div>
            
            <div class="bg-gradient-to-br from-amber-50 to-amber-100 p-6 rounded-xl">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-amber-600 rounded-full flex items-center justify-center ml-4">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">ساعات العمل</h3>
                </div>
                <p class="text-gray-700 text-sm leading-relaxed">
                    الأحد - الخميس: 9:00 ص - 6:00 م<br>
                    الجمعة: 9:00 ص - 1:00 م<br>
                    السبت: مغلق
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Google Maps Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    //_coordinates for Riyadh clinic (approximate location on King Fahd Street, Al-Olaya)
    const clinicLocation = { lat: 24.7136, lng: 46.6753 };
    
    // Create map
    const map = new google.maps.Map(document.getElementById('google-map'), {
        zoom: 15,
        center: clinicLocation,
        mapTypeId: 'roadmap',
        styles: [
            {
                "featureType": "all",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "weight": "2.00"
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#9c9c9c"
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels.text",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#f2f2f2"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100,
                        "lightness": 45
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#eeeeee"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#7b7b7b"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#46bcec",
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#c8d7d4"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#070707"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            }
        ]
    });
    
    // Create custom marker
    const marker = new google.maps.Marker({
        position: clinicLocation,
        map: map,
        title: 'عيادة د. عبدالناصر الأخرس',
        icon: {
            url: "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%231e40af'%3E%3Cpath d='M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z'/%3E%3C/svg%3E",
            scaledSize: new google.maps.Size(40, 40)
        },
        animation: google.maps.Animation.DROP
    });
    
    // Create info window
    const infoWindow = new google.maps.InfoWindow({
        content: `
            <div style="font-family: 'Segoe UI', Arial, sans-serif; direction: rtl; text-align: right; padding: 10px; max-width: 250px;">
                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                    <img src="{{ asset('images/favicon.png') }}" alt="شعار العيادة" style="width: 24px; height: 24px; margin-left: 8px;">
                    <h3 style="margin: 0; color: #1e40af; font-size: 16px; font-weight: bold;">عيادة د. عبدالناصر الأخرس</h3>
                </div>
                <p style="margin: 5px 0; color: #374151; font-size: 14px;">
                    <strong>التخصص:</strong> استشاري جراحات الشبكية والمياه البيضاء
                </p>
                <p style="margin: 5px 0; color: #374151; font-size: 14px;">
                    <strong>العنوان:</strong> شارع الملك فهد، حي العليا، الرياض
                </p>
                <p style="margin: 5px 0; color: #374151; font-size: 14px;">
                    <strong>ساعات العمل:</strong> الأحد - الخميس: 9:00 ص - 6:00 م
                </p>
                <div style="margin-top: 10px;">
                    <a href="tel:+966112345678" style="display: inline-block; padding: 8px 12px; background: #1e40af; color: white; text-decoration: none; border-radius: 6px; font-size: 12px; margin-left: 5px;">
                        اتصل الآن
                    </a>
                    <a href="https://wa.me/966112345678" target="_blank" style="display: inline-block; padding: 8px 12px; background: #25d366; color: white; text-decoration: none; border-radius: 6px; font-size: 12px;">
                        واتساب
                    </a>
                </div>
            </div>
        `
    });
    
    // Show info window on marker click
    marker.addListener('click', function() {
        infoWindow.open(map, marker);
    });
    
    // Show info window by default
    infoWindow.open(map, marker);
    
    // Hide loading indicator
    document.getElementById('map-loading').style.display = 'none';
});
</script>

<!-- Google Maps API -->
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgf7C5s6kU5qJ2Xc8J2T4Y0Qb3wE5R6Y7&callback=initMap&libraries=places">
</script>

<!-- Emergency Contact -->
<section class="py-20 bg-gradient-to-r from-red-600 to-red-700 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold mb-6">{{ __('طوارئ العيون') }}</h2>
        <p class="text-xl text-red-100 mb-8">
            {{ __('في حالات الطوارئ الطبية العاجلة، اتصل بنا فوراً') }}
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="tel:+966123456789" 
               class="bg-white text-red-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-red-50 transition-colors">
                {{ __('هاتف الطوارئ') }}
            </a>
            <a href="https://wa.me/966123456789" target="_blank"
               class="border-2 border-white text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-white hover:text-red-600 transition-colors">
                {{ __('واتساب طوارئ') }}
            </a>
        </div>
    </div>
</section>

</x-layouts.app>