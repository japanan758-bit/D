<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>مخصص الثيم - Theme Customizer</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        .color-picker-swatch {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.2s;
        }
        .color-picker-swatch:hover { transform: scale(1.1); }
        .color-picker-swatch.active { border-color: #3b82f6; transform: scale(1.1); }
    </style>
</head>
<body class="bg-gray-100" x-data="themeBuilder()" x-init="init()">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Controls -->
        <div class="w-80 bg-white border-l border-gray-200 flex flex-col shadow-lg z-10">
            <div class="p-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                <h2 class="font-bold text-gray-800">تخصيص المظهر</h2>
                <div class="flex gap-2">
                    <button @click="resetChanges" class="text-xs text-red-600 hover:text-red-800" title="إعادة تعيين">🔄</button>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto custom-scrollbar">
                <!-- Tabs -->
                <div class="flex border-b border-gray-200">
                    <button @click="activeTab = 'colors'" :class="{'border-b-2 border-blue-500 text-blue-600': activeTab === 'colors'}" class="flex-1 py-3 text-sm font-medium text-gray-600 hover:text-gray-800 transition">الألوان</button>
                    <button @click="activeTab = 'typography'" :class="{'border-b-2 border-blue-500 text-blue-600': activeTab === 'typography'}" class="flex-1 py-3 text-sm font-medium text-gray-600 hover:text-gray-800 transition">الخطوط</button>
                    <button @click="activeTab = 'layout'" :class="{'border-b-2 border-blue-500 text-blue-600': activeTab === 'layout'}" class="flex-1 py-3 text-sm font-medium text-gray-600 hover:text-gray-800 transition">التخطيط</button>
                </div>

                <!-- Colors Tab -->
                <div x-show="activeTab === 'colors'" class="p-4 space-y-6">
                    <!-- Color Scheme Presets -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">أنظمة ألوان جاهزة</label>
                        <div class="grid grid-cols-4 gap-2">
                            <button @click="applyColorScheme('blue')" class="w-full h-8 rounded bg-blue-500 hover:opacity-80 transition"></button>
                            <button @click="applyColorScheme('green')" class="w-full h-8 rounded bg-green-500 hover:opacity-80 transition"></button>
                            <button @click="applyColorScheme('purple')" class="w-full h-8 rounded bg-purple-500 hover:opacity-80 transition"></button>
                            <button @click="applyColorScheme('red')" class="w-full h-8 rounded bg-red-500 hover:opacity-80 transition"></button>
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    <!-- Custom Colors -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">اللون الأساسي</label>
                            <div class="flex gap-2">
                                <input type="color" x-model="settings.primary_color" class="h-8 w-12 rounded cursor-pointer">
                                <input type="text" x-model="settings.primary_color" class="flex-1 border-gray-300 rounded-md text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">اللون الثانوي</label>
                            <div class="flex gap-2">
                                <input type="color" x-model="settings.secondary_color" class="h-8 w-12 rounded cursor-pointer">
                                <input type="text" x-model="settings.secondary_color" class="flex-1 border-gray-300 rounded-md text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">لون الخلفية</label>
                            <div class="flex gap-2">
                                <input type="color" x-model="settings.background_color" class="h-8 w-12 rounded cursor-pointer">
                                <input type="text" x-model="settings.background_color" class="flex-1 border-gray-300 rounded-md text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">لون النص</label>
                            <div class="flex gap-2">
                                <input type="color" x-model="settings.text_color" class="h-8 w-12 rounded cursor-pointer">
                                <input type="text" x-model="settings.text_color" class="flex-1 border-gray-300 rounded-md text-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Typography Tab -->
                <div x-show="activeTab === 'typography'" class="p-4 space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">نوع الخط</label>
                        <select x-model="typography.font_family" class="w-full border-gray-300 rounded-md text-sm">
                            <option value="Cairo">Cairo (العربية)</option>
                            <option value="Tajawal">Tajawal</option>
                            <option value="Almarai">Almarai</option>
                            <option value="IBM Plex Sans Arabic">IBM Plex Sans</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">حجم الخط الأساسي</label>
                        <div class="flex items-center gap-2">
                            <input type="range" min="12" max="24" step="1" x-model="typography.font_size_base" class="w-full">
                            <span class="text-sm text-gray-500 w-8" x-text="typography.font_size_base + 'px'"></span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ارتفاع السطر</label>
                        <select x-model="typography.line_height" class="w-full border-gray-300 rounded-md text-sm">
                            <option value="1.2">مضغوط (1.2)</option>
                            <option value="1.5">طبيعي (1.5)</option>
                            <option value="1.8">مريح (1.8)</option>
                        </select>
                    </div>
                </div>

                <!-- Layout Tab -->
                <div x-show="activeTab === 'layout'" class="p-4 space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">نمط التخطيط</label>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 p-2 border rounded-md cursor-pointer hover:bg-gray-50" :class="{'border-blue-500 bg-blue-50': settings.layout_type === 'full-width'}">
                                <input type="radio" name="layout" value="full-width" x-model="settings.layout_type" class="text-blue-600">
                                <span class="text-sm">عرض كامل (Full Width)</span>
                            </label>
                            <label class="flex items-center gap-2 p-2 border rounded-md cursor-pointer hover:bg-gray-50" :class="{'border-blue-500 bg-blue-50': settings.layout_type === 'boxed'}">
                                <input type="radio" name="layout" value="boxed" x-model="settings.layout_type" class="text-blue-600">
                                <span class="text-sm">صندوق (Boxed)</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">انحناء الحواف (Border Radius)</label>
                        <div class="flex items-center gap-2">
                            <input type="range" min="0" max="24" step="2" x-model="settings.border_radius" class="w-full">
                            <span class="text-sm text-gray-500 w-8" x-text="settings.border_radius + 'px'"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 border-t border-gray-200 bg-gray-50">
                <button @click="saveChanges" class="w-full py-2 bg-blue-600 text-white rounded-md font-medium hover:bg-blue-700 transition flex justify-center items-center gap-2" :disabled="isSaving">
                    <span x-show="isSaving" class="animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>
                    <span x-text="isSaving ? 'جاري الحفظ...' : 'حفظ التغييرات'"></span>
                </button>
            </div>
        </div>

        <!-- Preview Area -->
        <div class="flex-1 bg-gray-100 flex flex-col overflow-hidden relative">
            <!-- Preview Toolbar -->
            <div class="h-14 bg-white border-b border-gray-200 flex justify-center items-center gap-4">
                <button @click="previewMode = 'desktop'" :class="{'text-blue-600 bg-blue-50': previewMode === 'desktop'}" class="p-2 rounded hover:bg-gray-100" title="Desktop">🖥️</button>
                <button @click="previewMode = 'tablet'" :class="{'text-blue-600 bg-blue-50': previewMode === 'tablet'}" class="p-2 rounded hover:bg-gray-100" title="Tablet">📱</button>
                <button @click="previewMode = 'mobile'" :class="{'text-blue-600 bg-blue-50': previewMode === 'mobile'}" class="p-2 rounded hover:bg-gray-100" title="Mobile">📱</button>
            </div>

            <!-- Preview Frame -->
            <div class="flex-1 overflow-auto p-8 flex justify-center items-start bg-gray-200">
                <div :class="{
                        'w-full max-w-full h-full': previewMode === 'desktop',
                        'w-[768px] h-[1024px]': previewMode === 'tablet',
                        'w-[375px] h-[667px]': previewMode === 'mobile'
                    }" class="bg-white shadow-2xl transition-all duration-300 origin-top transform scale-95 border-8 border-gray-800 rounded-xl overflow-hidden relative">

                    <!-- Live Preview of CSS -->
                    <style x-text="generatedCSS"></style>

                    <!-- Mock Content for Preview -->
                    <div class="h-full overflow-y-auto">
                        <!-- Header -->
                        <header class="p-4 border-b flex justify-between items-center" :style="{ backgroundColor: settings.background_color }">
                            <div class="font-bold text-xl" :style="{ color: settings.primary_color }">Clinic Logo</div>
                            <nav class="flex gap-4 text-sm" :style="{ color: settings.text_color }">
                                <a href="#">الرئيسية</a>
                                <a href="#">خدماتنا</a>
                                <a href="#">اتصل بنا</a>
                            </nav>
                        </header>

                        <!-- Hero Section -->
                        <div class="py-20 px-8 text-center" :style="{ backgroundColor: settings.surface_color }">
                            <h1 class="text-4xl font-bold mb-4" :style="{ color: settings.text_color }">عنوان رئيسي كبير ومميز</h1>
                            <p class="text-lg mb-8 opacity-80" :style="{ color: settings.text_color }">وصف مختصر يوضح الخدمات المقدمة بشكل جذاب.</p>
                            <button class="px-6 py-3 rounded text-white font-bold" :style="{ backgroundColor: settings.primary_color, borderRadius: settings.border_radius + 'px' }">احجز موعداً الآن</button>
                        </div>

                        <!-- Services Grid -->
                        <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                            <template x-for="i in 3">
                                <div class="p-6 border rounded shadow-sm" :style="{ backgroundColor: 'white', borderColor: settings.surface_color, borderRadius: settings.border_radius + 'px' }">
                                    <div class="w-12 h-12 mb-4 rounded flex items-center justify-center text-white" :style="{ backgroundColor: settings.secondary_color, borderRadius: settings.border_radius + 'px' }">★</div>
                                    <h3 class="font-bold mb-2" :style="{ color: settings.text_color }">خدمة طبية مميزة</h3>
                                    <p class="text-sm opacity-70" :style="{ color: settings.text_color }">تفاصيل الخدمة الطبية تظهر هنا بشكل مختصر.</p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div x-show="toast.visible" x-transition class="fixed bottom-4 right-4 bg-gray-800 text-white px-6 py-3 rounded shadow-lg z-50">
        <span x-text="toast.message"></span>
    </div>

    <script>
        function themeBuilder() {
            return {
                activeTab: 'colors',
                previewMode: 'desktop',
                isSaving: false,
                toast: { visible: false, message: '' },
                themeId: new URLSearchParams(window.location.search).get('theme_id'),

                // Initial Settings
                settings: {
                    primary_color: '#3b82f6',
                    secondary_color: '#64748b',
                    background_color: '#ffffff',
                    surface_color: '#f8fafc',
                    text_color: '#1f2937',
                    layout_type: 'full-width',
                    border_radius: '8'
                },

                typography: {
                    font_family: 'Cairo',
                    font_size_base: '16',
                    line_height: '1.5'
                },

                init() {
                    // Load existing settings if available
                    if (this.themeId) {
                        this.loadThemeData();
                    }
                },

                async loadThemeData() {
                    try {
                        const response = await fetch(`/theme-builder/theme/${this.themeId}`);
                        const data = await response.json();

                        if (data.theme) {
                            // Merge settings
                            this.settings = { ...this.settings, ...(data.settings || {}) };
                            this.typography = { ...this.typography, ...(data.typography || {}) };

                            // Load colors specifically if they exist in root settings
                            const colors = ['primary_color', 'secondary_color', 'background_color', 'surface_color', 'text_color'];
                            colors.forEach(color => {
                                if (data.settings && data.settings[color]) {
                                    this.settings[color] = data.settings[color];
                                }
                            });
                        }
                    } catch (error) {
                        console.error('Error loading theme data:', error);
                        this.showToast('خطأ في تحميل بيانات الثيم');
                    }
                },

                get generatedCSS() {
                    return `
                        :root {
                            --theme-primary: ${this.settings.primary_color};
                            --theme-secondary: ${this.settings.secondary_color};
                            --theme-background: ${this.settings.background_color};
                            --theme-surface: ${this.settings.surface_color};
                            --theme-text: ${this.settings.text_color};
                            --border-radius: ${this.settings.border_radius}px;
                        }
                        body {
                            font-family: "${this.typography.font_family}", sans-serif;
                            font-size: ${this.typography.font_size_base}px;
                            line-height: ${this.typography.line_height};
                            color: ${this.settings.text_color};
                            background-color: ${this.settings.background_color};
                        }
                    `;
                },

                applyColorScheme(scheme) {
                    const schemes = {
                        blue: { primary: '#3b82f6', secondary: '#64748b' },
                        green: { primary: '#22c55e', secondary: '#475569' },
                        purple: { primary: '#a855f7', secondary: '#64748b' },
                        red: { primary: '#ef4444', secondary: '#71717a' }
                    };

                    if (schemes[scheme]) {
                        this.settings.primary_color = schemes[scheme].primary;
                        this.settings.secondary_color = schemes[scheme].secondary;
                        this.showToast('تم تطبيق نظام الألوان: ' + scheme);
                    }
                },

                async saveChanges() {
                    if (!this.themeId) {
                        this.showToast('خطأ: لم يتم تحديد الثيم');
                        return;
                    }

                    this.isSaving = true;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    try {
                        // 1. Save Settings & Layout
                        const settingsResponse = await fetch(`/theme-builder/theme/${this.themeId}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                settings: this.settings,
                                layout_type: this.settings.layout_type
                            })
                        });

                        // 2. Save Typography
                        const typographyResponse = await fetch(`/theme-builder/theme/${this.themeId}/typography`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                ...this.typography,
                                line_height_normal: this.typography.line_height // Map correctly to controller expectations
                            })
                        });

                        // 3. Save Colors
                        const colorsResponse = await fetch(`/theme-builder/theme/${this.themeId}/colors`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                primary_color: this.settings.primary_color,
                                secondary_color: this.settings.secondary_color,
                                background_color: this.settings.background_color,
                                surface_color: this.settings.surface_color,
                                text_color: this.settings.text_color
                            })
                        });

                        if (settingsResponse.ok && typographyResponse.ok && colorsResponse.ok) {
                            this.showToast('تم حفظ جميع التغييرات بنجاح!');
                        } else {
                            throw new Error('فشل في حفظ بعض الإعدادات');
                        }

                    } catch (error) {
                        console.error('Error saving theme:', error);
                        this.showToast('حدث خطأ أثناء الحفظ');
                    } finally {
                        this.isSaving = false;
                    }
                },

                resetChanges() {
                    if(confirm('هل أنت متأكد من إعادة تعيين جميع الإعدادات؟')) {
                        this.settings.primary_color = '#3b82f6';
                        this.settings.secondary_color = '#64748b';
                        this.typography.font_family = 'Cairo';
                        this.showToast('تمت إعادة التعيين');
                    }
                },

                showToast(message) {
                    this.toast.message = message;
                    this.toast.visible = true;
                    setTimeout(() => this.toast.visible = false, 3000);
                }
            }
        }
    </script>
</body>
</html>
