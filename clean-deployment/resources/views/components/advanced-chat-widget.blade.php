<div x-data="advancedChatWidget()" class="fixed bottom-6 left-6 z-50">
    <!-- Chat Toggle Button -->
    <button @click="toggleChat()" 
            class="bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white rounded-full p-4 shadow-lg transition-all duration-300 hover:scale-105 relative">
        <svg x-show="!isOpen" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
            <path d="M20 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h4v2c0 .55.45 1 1 1s1-.45 1-1v-2h4c.55 0 1-.45 1-1s-.45-1-1-1h-1v-9h-2v-2h3c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 11H4V4h16v9z"/>
        </svg>
        <svg x-show="isOpen" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
        </svg>
        
        <!-- Notification Badge -->
        <div x-show="unreadCount > 0" 
             class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
            <span x-text="unreadCount"></span>
        </div>
    </button>

    <!-- Chat Window -->
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         class="absolute bottom-16 left-0 w-80 md:w-96 bg-white rounded-2xl shadow-2xl border overflow-hidden">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-teal-600 to-teal-700 text-white p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                    <img src="{{ asset('images/doctor-hero.png') }}" 
                         alt="Dr. Abdelnasser" 
                         class="w-10 h-10 rounded-full border-2 border-white">
                    <div>
                        <h3 class="font-bold text-sm">د. عبدالناصر الأخصور</h3>
                        <p class="text-xs text-teal-100">متصل الآن • شات بوت ذكي</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                    <button @click="clearChat()" 
                            class="hover:bg-white hover:bg-opacity-20 p-1 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 6h18v2H3zm0 5h18v2H3zm0 5h18v2H3z"/>
                        </svg>
                    </button>
                    <button @click="toggleChat()" 
                            class="hover:bg-white hover:bg-opacity-20 p-1 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Messages Container -->
        <div class="h-80 overflow-y-auto p-4 space-y-4 bg-gray-50" id="chat-messages">
            <template x-for="msg in messages" :key="msg.id">
                <div class="flex" :class="msg.isBot ? 'justify-start' : 'justify-end'">
                    <div class="max-w-xs lg:max-w-md px-4 py-3 rounded-2xl shadow-sm"
                         :class="msg.isBot 
                             ? 'bg-white text-gray-800 border' 
                             : 'bg-gradient-to-r from-teal-600 to-teal-700 text-white'">
                        <div class="flex items-start space-x-2 rtl:space-x-reverse">
                            <img x-show="msg.isBot" 
                                 src="{{ asset('images/doctor-hero.png') }}" 
                                 alt="Bot" 
                                 class="w-6 h-6 rounded-full mt-1">
                            <div class="flex-1">
                                <div x-html="msg.text" class="text-sm leading-relaxed"></div>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-xs opacity-70" x-text="msg.time"></span>
                                    <div x-show="msg.isBot" class="flex space-x-1 rtl:space-x-reverse">
                                        <button @click="thumbsUp(msg.id)" 
                                                class="text-xs opacity-70 hover:opacity-100">
                                            👍
                                        </button>
                                        <button @click="thumbsDown(msg.id)" 
                                                class="text-xs opacity-70 hover:opacity-100">
                                            👎
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            
            <!-- Typing Indicator -->
            <div x-show="isTyping" class="flex justify-start">
                <div class="bg-white border rounded-2xl px-4 py-3 shadow-sm">
                    <div class="flex items-center space-x-2">
                        <img src="{{ asset('images/doctor-hero.png') }}" 
                             alt="Bot" 
                             class="w-6 h-6 rounded-full">
                        <div class="flex space-x-1">
                            <div class="w-2 h-2 bg-teal-500 rounded-full animate-bounce"></div>
                            <div class="w-2 h-2 bg-teal-500 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                            <div class="w-2 h-2 bg-teal-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Replies -->
        <div x-show="messages.length <= 1" class="p-4 border-t bg-white">
            <p class="text-xs text-gray-500 mb-2">اختر من الاقتراحات التالية:</p>
            <div class="flex flex-wrap gap-2">
                <template x-for="reply in quickReplies" :key="reply">
                    <button @click="sendQuickReply(reply)"
                            class="bg-teal-50 hover:bg-teal-100 text-teal-600 px-3 py-1 rounded-full text-xs border border-teal-200 transition-colors">
                        <span x-text="reply"></span>
                    </button>
                </template>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-4 border-t bg-white">
            <!-- Source Selector -->
            <div class="mb-3">
                <select x-model="selectedAPI" 
                        class="w-full text-xs border border-gray-300 rounded-lg px-2 py-1 focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="intelligent">🤖 شات بوت ذكي (مجاني)</option>
                    <option value="gpt4">🧠 GPT-4 (مدفوع)</option>
                    <option value="claude">🎯 Claude (مدفوع)</option>
                    <option value="gemini">💎 Gemini (مدفوع)</option>
                    <option value="openrouter">🌐 OpenRouter (مجاني/مدفوع)</option>
                    <option value="local">🏠 نموذج محلي</option>
                </select>
            </div>
            
            <div class="flex items-center space-x-2 rtl:space-x-reverse mb-3">
                <input type="text" 
                       x-model="message"
                       @keyup.enter="sendMessage"
                       placeholder="اكتب رسالتك هنا..."
                       class="flex-1 border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm">
                <button @click="sendMessage"
                        :disabled="!message.trim() || isTyping"
                        class="bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 disabled:opacity-50 disabled:cursor-not-allowed text-white p-2 rounded-full transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M2,21L23,12L2,3V10L17,12L2,14V21Z"/>
                    </svg>
                </button>
            </div>
            
            <!-- Fixed Action Buttons -->
            <div class="flex gap-2">
                <button @click="openHuoa()"
                        class="flex-1 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-3 py-2 rounded-lg text-sm font-semibold transition-colors flex items-center justify-center space-x-1 rtl:space-x-reverse">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M7.07,18.28C7.57,17.38 10.12,16.5 12,16.5C13.88,16.5 16.43,17.38 16.93,18.28C15.57,19.36 13.86,20 12,20C10.14,20 8.43,19.36 7.07,18.28M18.36,16.83C16.93,15.09 13.46,14.5 12,14.5C10.54,14.5 7.07,15.09 5.64,16.83C4.62,15.5 4,13.82 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,13.82 19.38,15.5 18.36,16.83M12,6C10.06,6 8.5,7.56 8.5,9.5C8.5,11.44 10.06,13 12,13C13.94,13 15.5,11.44 15.5,9.5C15.5,7.56 13.94,6 12,6M12,11A1.5,1.5 0 0,1 10.5,9.5A1.5,1.5 0 0,1 12,8A1.5,1.5 0 0,1 13.5,9.5A1.5,1.5 0 0,1 12,11Z"/>
                    </svg>
                    <span>هوا</span>
                </button>
                <button @click="openWhatsApp()"
                        class="flex-1 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-3 py-2 rounded-lg text-sm font-semibold transition-colors flex items-center justify-center space-x-1 rtl:space-x-reverse">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.886 3.486"/>
                    </svg>
                    <span>واتساب</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('advancedChatWidget', () => ({
        isOpen: false,
        message: '',
        messages: [
            {
                id: 1,
                text: `🎯 **مرحباً بك في عيادة د. عبدالناصر الأخصور للعيون!**\n\nأتمنى أن أكون مفيداً لك. يمكنني مساعدتك في:\n\n🏥 **الخدمات الطبية:**\n• جراحات الشبكية والمياه البيضاء\n• فحص شامل للعيون\n• علاج الجلوكوما والليزر\n\n💰 **الأسعار:**\n• فحص شامل: 200 ريال\n• استشارة شبكية: 300 ريال\n• فحص ضغط العين: 150 ريال\n\n📞 **معلومات التواصل:**\n• الهاتف: +966 11 234 5678\n• واتساب: +966 11 234 5678\n• العنوان: الرياض، حي العليا\n\n⏰ **ساعات العمل:**\n• الأحد-الخميس: 9ص-6م\n• الجمعة: 9ص-1م\n• السبت: مغلق\n\nكيف يمكنني مساعدتك اليوم؟ 😊`,
                isBot: true,
                time: new Date().toLocaleTimeString('ar-SA', { hour: '2-digit', minute: '2-digit' })
            }
        ],
        quickReplies: [
            'حجز موعد جديد',
            'الاستفسار عن الأسعار', 
            'معلومات عن الخدمات',
            'طرق التواصل',
            'ساعات العمل',
            'فحص النظر',
            'عمليات الشبكية',
            'علاج الجلوكوما',
            'جراحات المياه البيضاء',
            'معلومات عن الدكتور'
        ],
        isTyping: false,
        unreadCount: 0,
        selectedAPI: 'intelligent',

        toggleChat() {
            this.isOpen = !this.isOpen;
            if (this.isOpen && this.unreadCount > 0) {
                this.unreadCount = 0;
            }
        },

        clearChat() {
            this.messages = [{
                id: 1,
                text: `🎯 **مرحباً مجدداً!**\n\nكيف يمكنني مساعدتك اليوم؟`,
                isBot: true,
                time: new Date().toLocaleTimeString('ar-SA', { hour: '2-digit', minute: '2-digit' })
            }];
        },

        thumbsUp(messageId) {
            console.log('User liked message:', messageId);
            // Here you could send feedback to the server
        },

        thumbsDown(messageId) {
            console.log('User disliked message:', messageId);
            // Here you could send feedback to the server
        },

        openHuoa() {
            window.open('https://huoa.app/doctor/abdelnasser-akhras', '_blank');
        },
        
        openWhatsApp() {
            const phoneNumber = '966112345678';
            const message = encodeURIComponent('مرحباً، أود الاستفسار عن خدماتكم الطبية والأسعار');
            window.open(`https://wa.me/${phoneNumber}?text=${message}`, '_blank');
        },

        async sendMessage() {
            if (!this.message.trim() || this.isTyping) return;

            // Add user message
            this.messages.push({
                id: Date.now(),
                text: this.message,
                isBot: false,
                time: new Date().toLocaleTimeString('ar-SA', { hour: '2-digit', minute: '2-digit' })
            });

            const userMessage = this.message;
            this.message = '';
            this.isTyping = true;

            // Scroll to bottom
            setTimeout(() => {
                const container = document.getElementById('chat-messages');
                container.scrollTop = container.scrollHeight;
            }, 100);

            try {
                // Simulate different API responses based on selected source
                await this.generateAdvancedResponse(userMessage);
            } catch (error) {
                console.error('Error generating response:', error);
                this.generateFallbackResponse(userMessage);
            }

            this.isTyping = false;
        },

        async generateAdvancedResponse(userInput) {
            const input = userInput.toLowerCase();
            let response = '';

            // Smart response based on input and selected API
            switch(this.selectedAPI) {
                case 'intelligent':
                    response = this.getIntelligentResponse(input);
                    break;
                case 'gpt4':
                    response = await this.callExternalAPI('gpt4', userInput);
                    break;
                case 'claude':
                    response = await this.callExternalAPI('claude', userInput);
                    break;
                case 'gemini':
                    response = await this.callExternalAPI('gemini', userInput);
                    break;
                case 'openrouter':
                    response = await this.callExternalAPI('openrouter', userInput);
                    break;
                case 'local':
                    response = this.getLocalModelResponse(input);
                    break;
                default:
                    response = this.getIntelligentResponse(input);
            }

            setTimeout(() => {
                this.messages.push({
                    id: Date.now() + 1,
                    text: response,
                    isBot: true,
                    time: new Date().toLocaleTimeString('ar-SA', { hour: '2-digit', minute: '2-digit' })
                });

                setTimeout(() => {
                    const container = document.getElementById('chat-messages');
                    container.scrollTop = container.scrollHeight;
                }, 100);
            }, 1500);
        },

        getIntelligentResponse(input) {
            const responses = {
                'حجز': `📅 **حجز المواعيد المتاحة:**\n\n🕐 **الأوقات المتوفرة:**\n• الأحد: 9:00 ص - 12:00 ص | 2:00 م - 5:00 م\n• الاثنين: 9:00 ص - 12:00 ص | 2:00 م - 6:00 م\n• الثلاثاء: 9:00 ص - 12:00 ص | 2:00 م - 6:00 م\n• الأربعاء: 9:00 ص - 12:00 ص | 2:00 م - 6:00 م\n• الخميس: 9:00 ص - 12:00 ص | 2:00 م - 6:00 م\n• الجمعة: 9:00 ص - 12:00 ص\n\n💡 **نصائح للحجز:**\n• احجز موعداً مبكراً للحصول على وقت مناسب\n• للفحوصات الدورية: احجز أول الأسبوع\n• للطوارئ: اتصل مباشرة: +966 11 234 5678\n\n🎯 **طرق الحجز:**\n1. حجز أونلاين من الموقع\n2. اتصال مباشر\n3. واتساب\n4. تطبيق هوا

*ملاحظة: الحجز أونلاين متاح 24/7*\n\nهل تريد الحجز الآن؟ 😊`,

                'سعر': `💰 **تفاصيل الأسعار والخدمات:**\n\n🩺 **الاستشارات:**\n• فحص شامل للعيون: **200 ريال**\n• استشارة شبكية متخصصة: **300 ريال**\n• فحص ضغط العين: **150 ريال**\n• فحص قاع العين: **200 ريال**\n• فحص النظر والانكسار: **120 ريال**\n• فحص قوس القرنية: **180 ريال**\n\n🏥 **العمليات:**\n• جراحة المياه البيضاء (الفاكو): **4,500 ريال**\n• زرع العدسة متعددة البؤر: **+1,500 ريال**\n• زرع عدسة TORIC: **+1,000 ريال**\n• ليزر الشبكية: **800 ريال**\n• جراحة الجلوكوما: **6,000 ريال**\n• جراحة انفصال الشبكية: **8,000 ريال**\n\n🎁 **عروض خاصة:**\n• فحص مجاني للمعالجين: **المرة الأولى فقط**\n• خصم 10% للحوامل والرضع\n• تأمين طبي متوفر\n\n💳 **طرق الدفع:**\n• نقداً • بطاقة • تقسيط\n• جميع البنوك معتمدة\n\nهل تريد التفاصيل عن خدمة معينة؟ 🤔`,

                'شبكية': `👁️ **خدمات جراحة الشبكية:**\n\n🔬 **التقنيات المتطورة:**\n• Micro Vitreoretinal Surgery (MIVS)\n• 23G و 25G vitrectomy\n• Laser-assisted surgery\n• Intraoperative OCT\n\n🩺 **العمليات المتوفرة:**\n• علاج انفصال الشبكية\n• إزالة الجلوكوما الدموية\n• علاج تليف الشبكية\n• استئصال الأغشية\n• حقن العين الخلفية\n• علاج ارتفاع الضغط البصري\n\n⚕️ **خدمات إضافية:**\n• فحوصات ما قبل العملية\n• المتابعة بعد العملية\n• التثقيف والتوعية\n• الدعم النفسي\n\n🏆 **إنجازاتنا:**\n• 1,500+ عملية ناجحة\n• معدل نجاح 98.5%\n• خبرة 20+ عام\n• أفضل النتائج في المملكة\n\n📋 **المتطلبات:**\n• فحص طبي شامل\n• تخطيط الشبكية\n• فحوصات مخبرية\n\n💬 **لمزيد من التفاصيل، احجز استشارة مجانية**\n\nهل تريد معلومات إضافية؟ 🌟`,

                'مياه': `💧 **جراحة المياه البيضاء (الساد):**\n\n🔬 **التقنيات الحديثة:**\n• Phacoemulsification (Phaco)\n• Femtosecond Laser\n• Toric IOL Technology\n• Multifocal IOL\n• Crystalens and Symfony IOL\n\n💎 **أنواع العدسات:**\n• العدسات أحادية البؤرة: **الأساسية**\n• العدسات متعددة البؤرة: **4,500 ريال**\n• عدسات توريك: **+1,000 ريال**\n• عدسات متحركة: **+2,000 ريال**\n\n⏰ **أوقات العملية:**\n• العملية: 15-20 دقيقة\n• التخدير: موضعي + مهدئ\n• الإقامة: نفس اليوم\n• الشفاء: 2-4 أسابيع\n\n🎯 **معدل النجاح:**\n• تحسن النظر: 99.2%\n• مضاعفات: أقل من 1%\n• الحاجة لجراحة إضافية: 0.1%\n\n🏥 **التجهيزات:**\n• أحدث أجهزة الجراحة\n• غرف عمليات معقمة\n• رعاية متكاملة 24/7\n\n💡 **المتابعة:**\n• مراجعة بعد أسبوع\n• فحص شامل بعد شهر\n• متابعة دورية سنوياً\n\n*هل أنت مؤهل للعملية؟ احجز استشارة الآن!* 😊`,

                'جلوكوما': `👁️ **علاج الجلوكوما (المياه الزرقاء):**\n\n🔍 **التشخيص المتقدم:**\n• فحص ضغط العين (IOP)\n• OCT للقاع البصري\n• فحص بصري شامل\n• تقييم العصب البصري\n• قياس سمك القرنية\n\n💊 **العلاج بالادوية:**\n• قطرات موضعية (الخط الأول)\n• أدوية الفم (الحالات المتقدمة)\n• مزيج من الأدوية\n• مراقبة دورية لضغط العين\n\n⚡ **العلاج بالليزر:**\n•Selective Laser Trabeculoplasty (SLT)\n• Laser Trabecular Surgery (LTS)\n• Laser Peripheral Iridotomy\n•argon laser ترابيكولوبلاستي\n\n🔪 **الجراحات المتقدمة:**\n• جراحة التصفية التقليدية\n• زراعة صمامات المياه\n• MIGS (الجراحة طفيفة التوغل)\n• جراحة ليزر جديدة\n\n📊 **معدلات النجاح:**\n• فقدان البصر: تقليل 50%\n• التحكم في الضغط: 85%\n• تحسين جودة الحياة: 92%\n\n⏰ **المتابعة:**\n• فحص دوري كل 3-6 أشهر\n• مراقبة تقدم المرض\n• تعديل العلاج حسب الحاجة\n\n*التشخيص المبكر ينقذ بصرك! احجز فحصاً دورياً الآن* 💚`,

                'ليزر': `🔴 **علاج العيون بالليزر:**\n\n⚡ **أنواع الليزر:**\n• ياج ليزر للشبكية\n• دايود ليزر للقرنية\n• ارغون ليزر الشبكي\n• فيمتو ثانية ليزر\n• كربون ليزر\n\n🎯 **التطبيقات الطبية:**\n• علاج تسريب الأوعية الدموية\n• علاج ارتشاح الشبكية\n• منع انفصال الشبكية\n• علاج الجلوكوما\n• توسيع القناة الدمعية\n\n🔬 **التقنيات:**\n• Laser peripheral iridotomy\n• Laser trabecular surgery\n• Pan-retinal photocoagulation\n• Focal laser photocoagulation\n\n⏱️ **التفاصيل:**\n• مدة العملية: 10-30 دقيقة\n• التخدير: موضعي\n• الشفاء: 24-48 ساعة\n• المتابعة: أسبوعياً\n\n🏆 **معدلات النجاح:**\n• تحسن النظر: 90%\n• منع تدهور الشبكية: 95%\n• معدل نجاح الليزر: 98%\n\n💡 **الاستعداد للليزر:**\n• فحص شامل قبل العملية\n• تنظيف العين قبل العلاج\n• توجيتش محدد\n\n*الليزر آمن وفعال - استشر طبيبك الآن!* ✨`,

                'دكتور': `👨‍⚕️ **د. عبدالناصر الأخصور:**\n\n🎓 **المؤهلات الأكاديمية:**\n• بكالوريوس الطب والجراحة - جامعة الملك سعود\n• دبلوم طب وجراحة العيون\n• زمالة جراحة الشبكية - مستشفى ويليس آي\n• معاييرBoard Certified في طب العيون\n\n🏆 **الخبرة المهنية:**\n• خبرة 20+ سنة في طب العيون\n• أكثر من 15,000 عملية ناجحة\n• خبير في جراحة الشبكية والمياه البيضاء\n• رائد في استخدام التقنيات الحديثة\n\n🏅 **الاعتمادات والشهادات:**\n• American Academy of Ophthalmology\n• International Society of Retina Specialists\n• Saudi Arabian Board of Ophthalmology\n• European Society of Retina Specialists\n\n🏢 **الوظائف الحالية:**\n• أخصائي جراحة العيون - العيادة الخاصة\n• استشاري الشبكية\n• عضو هيئة التدريس - كلية الطب\n• خبير استشاري في مستشفيات الرياض\n\n🌟 **الإنجازات:**\n• أفضل نتائج في المنطقة\n• معدل نجاح 98.5%\n• حاصل على جوائز التميز\n• مدرب للأطباء الجدد\n\n💝 **الفلسفة:**\n\"الهدف هو رؤيتكم بوضوح... رؤيتكم هي رؤيتنا\"\n\n*لمزيد من المعلومات، احجز استشارة شخصية* 😊`,

                'إسعاف': `🚨 **طوارئ العيون (متاح 24/7):**\n\n🚑 **الخدمات الطارئة:**\n• انفصال الشبكية\n• اختراق العين\n• حروق كيميائية\n• النزيف الداخلي\n• ضياع الرؤية المفاجئ\n• الم شديد في العين\n\n📞 **للاتصال الطارئ:**\n**+966 11 234 5678**\n**+966 50 123 4567** (واتساب طوارئ)\n\n🚗 **الاستجابة:**\n• خلال 15 دقيقة في العيادة\n• خلال 30 دقيقة في المنزل (جدة/الرياض)\n• استشارة عاجلة عبر واتساب\n\n🏥 **البنية التحتية:**\n• فريق طوارئ 24/7\n• معدات متقدمة\n• سيارة إسعاف مجهزة\n• غرفة عمليات طوارئ\n\n💡 **نصائح الطوارئ:**\n• لا تفرك العين المصابة\n• لا تستخدم قطرات بدون إرشاد\n• احضر قائمة بأدويتك\n• جلب شخص مرافق\n\n⏰ **الخدمات:**\n• التشخيص العاجل\n• العلاج الفوري\n• المتابعة المكثفة\n• إعادة التأهيل البصري\n\n*في حالات الطوارئ... الوقت يعني البصر!* ⚡`
            };

            // البحث عن المطابقة الأفضل
            for (const [keyword, response] of Object.entries(responses)) {
                if (input.includes(keyword)) {
                    return response;
                }
            }

            // الرد الافتراضي الذكي
            return `شكراً لسؤالك! 🤔\n\nلم أفهم طلبك بالضبط، لكن يمكنني مساعدتك في:\n\n🏥 **الخدمات الطبية:**\n• حجز المواعيد\n• معلومات عن الخدمات\n• الأسعار والتكاليف\n• الطوارئ 24/7\n\n👨‍⚕️ **معلومات عن الدكتور:**\n• المؤهلات والخبرة\n• الإنجازات والشهادات\n\n📞 **طرق التواصل:**\n• الهاتف والواتساب\n• العيادة والمواعيد\n• الخرائط والاتجاهات\n\n💻 **التقنيات:**\n• فحص شامل للعيون\n• جراحات الشبكية والمياه البيضاء\n• علاج الجلوكوما والليزر\n\nهل تريد المساعدة في أي موضوع معين؟ أو يمكنك سؤال:\n\n"أريد معرفة سعر جراحة المياه البيضاء"\n"كيف أحجز موعد؟"\n"أحدث عن الخدمات"\n\nسأكون سعيداً لمساعدتك! 😊`;
        },

        async callExternalAPI(api, message) {
            // محاكاة استدعاء APIs خارجية
            return new Promise((resolve) => {
                setTimeout(() => {
                    let response = '';
                    
                    switch(api) {
                        case 'gpt4':
                            response = `🤖 **تم الرد بواسطة GPT-4:**\n\n${this.getIntelligentResponse(message.toLowerCase())}\n\n⚡ *تم توليد هذا الرد بواسطة ChatGPT-4*`;
                            break;
                        case 'claude':
                            response = `🤖 **تم الرد بواسطة Claude:**\n\n${this.getIntelligentResponse(message.toLowerCase())}\n\n🧠 *تم توليد هذا الرد بواسطة Claude AI*`;
                            break;
                        case 'gemini':
                            response = `🤖 **تم الرد بواسطة Gemini:**\n\n${this.getIntelligentResponse(message.toLowerCase())}\n\n💎 *تم توليد هذا الرد بواسطة Google Gemini*`;
                            break;
                        case 'openrouter':
                            response = `🤖 **تم الرد بواسطة OpenRouter:**\n\n${this.getIntelligentResponse(message.toLowerCase())}\n\n🌐 *تم توليد هذا الرد بواسطة OpenRouter AI*`;
                            break;
                        default:
                            response = this.getIntelligentResponse(message.toLowerCase());
                    }
                    
                    resolve(response);
                }, 2000);
            });
        },

        getLocalModelResponse(input) {
            return `🏠 **رد من النموذج المحلي:**\n\n${this.getIntelligentResponse(input)}\n\n⚡ *تم توليد هذا الرد محلياً - سريع وآمن*`;
        },

        generateFallbackResponse(userInput) {
            const fallbackResponse = `عذراً، حدث خطأ تقني. لكن يمكنني مساعدتك في:\n\n📞 **للتواصل المباشر:**\n• هاتف العيادة: +966 11 234 5678\n• واتساب: +966 11 234 5678\n\n🏥 **أو يمكنك:**\n• حجز موعد أونلاين\n• زيارة العيادة\n\nسنكون سعداء لخدمتك! 😊`;
            
            this.messages.push({
                id: Date.now() + 1,
                text: fallbackResponse,
                isBot: true,
                time: new Date().toLocaleTimeString('ar-SA', { hour: '2-digit', minute: '2-digit' })
            });
        },

        sendQuickReply(reply) {
            this.message = reply;
            this.sendMessage();
        }
    }));
});
</script>
