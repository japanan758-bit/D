<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>محرر الصفحات - Page Builder</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- SortableJS for Drag & Drop -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    
    <style>
        /* Custom styles for page builder */
        .drag-zone {
            border: 2px dashed #e5e7eb;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        
        .drag-zone.drag-over {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }
        
        .component-item {
            cursor: move;
            transition: all 0.2s ease;
        }
        
        .component-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .component-item:active {
            cursor: grabbing;
        }
        
        .canvas-item {
            position: relative;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: white;
            transition: all 0.2s ease;
        }
        
        .canvas-item:hover {
            border-color: #3b82f6;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .canvas-item.selected {
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
        }
        
        .canvas-item.dragging {
            opacity: 0.5;
            transform: rotate(5deg);
        }
        
        .toolbar {
            opacity: 0;
            transition: opacity 0.2s ease;
        }
        
        .canvas-item:hover .toolbar {
            opacity: 1;
        }
        
        .preview-desktop { max-width: 1200px; }
        .preview-tablet { max-width: 768px; }
        .preview-mobile { max-width: 375px; }
        
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 400px;
        }
        
        .loading-spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
</head>
<body class="bg-gray-100" x-data="pageBuilder()" x-init="init()">

    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-full px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl">🎨</span>
                        <h1 class="text-xl font-bold text-gray-900">محرر الصفحات</h1>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button 
                            @click="resetCanvas"
                            class="px-3 py-1 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200">
                            🔄 إعادة تعيين
                        </button>
                        <button 
                            @click="importPage"
                            class="px-3 py-1 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200">
                            📁 استيراد
                        </button>
                        <button 
                            @click="exportPage"
                            class="px-3 py-1 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200">
                            💾 تصدير
                        </button>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Preview Mode -->
                    <div class="flex bg-gray-100 rounded-lg p-1">
                        <button 
                            @click="setPreviewMode('desktop')"
                            :class="previewMode === 'desktop' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-600'"
                            class="px-3 py-1 text-sm rounded">
                            💻 سطح المكتب
                        </button>
                        <button 
                            @click="setPreviewMode('tablet')"
                            :class="previewMode === 'tablet' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-600'"
                            class="px-3 py-1 text-sm rounded">
                            📱 الجهاز اللوحي
                        </button>
                        <button 
                            @click="setPreviewMode('mobile')"
                            :class="previewMode === 'mobile' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-600'"
                            class="px-3 py-1 text-sm rounded">
                            📱 الجوال
                        </button>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex space-x-2">
                        <button 
                            @click="savePage"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 flex items-center space-x-2">
                            <span>💾</span>
                            <span>حفظ الصفحة</span>
                        </button>
                        <button 
                            @click="saveAsTemplate"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 flex items-center space-x-2">
                            <span>⭐</span>
                            <span>حفظ كقالب</span>
                        </button>
                        <button 
                            @click="previewPage"
                            class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium hover:bg-purple-700 flex items-center space-x-2">
                            <span>👁️</span>
                            <span>معاينة</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="flex h-screen">
        <!-- Component Library -->
        <div class="w-80 bg-white border-l border-gray-200 flex flex-col">
            <!-- Search -->
            <div class="p-4 border-b border-gray-200">
                <input 
                    x-model="componentSearch"
                    type="text" 
                    placeholder="البحث في المكونات..."
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            
            <!-- Components List -->
            <div class="flex-1 overflow-y-auto custom-scrollbar" x-show="!showTemplates">
                <div class="p-4 space-y-6">
                    
                    <!-- Layout Components -->
                    <div class="space-y-2">
                        <h3 class="text-sm font-semibold text-gray-700 flex items-center">
                            <span class="mr-2">🎨</span>
                            تخطيط
                        </h3>
                        <div class="grid grid-cols-2 gap-2">
                            <template x-for="component in getFilteredComponents('layout')" :key="component.id">
                                <div 
                                    @click="addComponent(component.type)"
                                    class="component-item p-3 bg-gray-50 border border-gray-200 rounded-lg text-center hover:bg-gray-100">
                                    <div class="text-xl mb-1" x-text="component.icon"></div>
                                    <div class="text-xs font-medium text-gray-700" x-text="component.name"></div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Content Components -->
                    <div class="space-y-2">
                        <h3 class="text-sm font-semibold text-gray-700 flex items-center">
                            <span class="mr-2">📝</span>
                            محتوى
                        </h3>
                        <div class="grid grid-cols-2 gap-2">
                            <template x-for="component in getFilteredComponents('content')" :key="component.id">
                                <div 
                                    @click="addComponent(component.type)"
                                    class="component-item p-3 bg-gray-50 border border-gray-200 rounded-lg text-center hover:bg-gray-100">
                                    <div class="text-xl mb-1" x-text="component.icon"></div>
                                    <div class="text-xs font-medium text-gray-700" x-text="component.name"></div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- UI Components -->
                    <div class="space-y-2">
                        <h3 class="text-sm font-semibold text-gray-700 flex items-center">
                            <span class="mr-2">🧩</span>
                            واجهة مستخدم
                        </h3>
                        <div class="grid grid-cols-2 gap-2">
                            <template x-for="component in getFilteredComponents('ui')" :key="component.id">
                                <div 
                                    @click="addComponent(component.type)"
                                    class="component-item p-3 bg-gray-50 border border-gray-200 rounded-lg text-center hover:bg-gray-100">
                                    <div class="text-xl mb-1" x-text="component.icon"></div>
                                    <div class="text-xs font-medium text-gray-700" x-text="component.name"></div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Medical Components -->
                    <div class="space-y-2">
                        <h3 class="text-sm font-semibold text-gray-700 flex items-center">
                            <span class="mr-2">⚕️</span>
                            طبي
                        </h3>
                        <div class="grid grid-cols-2 gap-2">
                            <template x-for="component in getFilteredComponents('medical')" :key="component.id">
                                <div 
                                    @click="addComponent(component.type)"
                                    class="component-item p-3 bg-gray-50 border border-gray-200 rounded-lg text-center hover:bg-gray-100">
                                    <div class="text-xl mb-1" x-text="component.icon"></div>
                                    <div class="text-xs font-medium text-gray-700" x-text="component.name"></div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Interactive Components -->
                    <div class="space-y-2">
                        <h3 class="text-sm font-semibold text-gray-700 flex items-center">
                            <span class="mr-2">🎯</span>
                            تفاعلي
                        </h3>
                        <div class="grid grid-cols-2 gap-2">
                            <template x-for="component in getFilteredComponents('interactive')" :key="component.id">
                                <div 
                                    @click="addComponent(component.type)"
                                    class="component-item p-3 bg-gray-50 border border-gray-200 rounded-lg text-center hover:bg-gray-100">
                                    <div class="text-xl mb-1" x-text="component.icon"></div>
                                    <div class="text-xs font-medium text-gray-700" x-text="component.name"></div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Custom HTML -->
                    <div class="space-y-2">
                        <h3 class="text-sm font-semibold text-gray-700 flex items-center">
                            <span class="mr-2">💻</span>
                            مخصص
                        </h3>
                        <div class="grid grid-cols-2 gap-2">
                            <div 
                                @click="showCustomHTMLModal = true"
                                class="component-item p-3 bg-gray-50 border border-gray-200 rounded-lg text-center hover:bg-gray-100">
                                <div class="text-xl mb-1">💻</div>
                                <div class="text-xs font-medium text-gray-700">كود مخصص</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Templates List -->
            <div class="flex-1 overflow-y-auto custom-scrollbar" x-show="showTemplates" style="display: none;">
                <div class="p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-700">القوالب الجاهزة</h3>
                        <button 
                            @click="showTemplates = false"
                            class="text-xs text-blue-600 hover:text-blue-800">
                            إخفاء القوالب
                        </button>
                    </div>
                    
                    <div class="space-y-3">
                        <template x-for="template in templates" :key="template.id">
                            <div class="p-3 border border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 cursor-pointer"
                                 @click="loadTemplate(template.id)">
                                <h4 class="text-sm font-medium text-gray-900" x-text="template.name"></h4>
                                <p class="text-xs text-gray-600 mt-1" x-text="template.description"></p>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-xs text-gray-500" x-text="template.category"></span>
                                    <span class="text-xs" :class="template.is_premium ? 'text-purple-600' : 'text-green-600'" x-text="template.is_premium ? '⭐ مميز' : '🆓 مجاني'"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Canvas Area -->
        <div class="flex-1 flex flex-col bg-gray-100">
            <!-- Page Settings -->
            <div class="bg-white border-b border-gray-200 p-4">
                <div class="flex items-center space-x-6">
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-gray-700 mb-1">عنوان الصفحة</label>
                        <input 
                            x-model="pageTitle"
                            type="text" 
                            placeholder="عنوان الصفحة..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-gray-700 mb-1">الرابط</label>
                        <input 
                            x-model="pageSlug"
                            type="text" 
                            placeholder="my-page"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div class="flex items-end space-x-2">
                        <button 
                            @click="showTemplates = !showTemplates"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200">
                            📚 القوالب
                        </button>
                        <button 
                            @click="resetCanvas"
                            class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg text-sm hover:bg-yellow-200">
                            🗑️ مسح الكل
                        </button>
                    </div>
                </div>
            </div>

            <!-- Canvas -->
            <div class="flex-1 overflow-y-auto custom-scrollbar p-6">
                <div class="max-w-4xl mx-auto">
                    
                    <!-- Empty State -->
                    <div x-show="components.length === 0" class="text-center py-20">
                        <div class="text-6xl mb-6">🎨</div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">ابدأ في بناء صفحتك</h2>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">
                            اسحب المكونات من الشريط الجانبي الأيسر وأفلتها هنا لبناء صفحة مذهلة
                        </p>
                        <div class="flex justify-center space-x-4">
                            <button 
                                @click="addComponent('hero')"
                                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                                🌟 إضافة قسم رئيسي
                            </button>
                            <button 
                                @click="showTemplates = true"
                                class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium">
                                📚 تصفح القوالب
                            </button>
                        </div>
                    </div>

                    <!-- Components Canvas -->
                    <div x-show="components.length > 0" class="space-y-4">
                        <template x-for="(component, index) in components" :key="component.id">
                            <div 
                                class="canvas-item p-4"
                                :class="selectedComponent === component.id ? 'selected' : ''"
                                @click="selectComponent(component.id)">
                                
                                <!-- Toolbar -->
                                <div class="toolbar absolute -top-12 left-0 right-0 bg-white shadow-lg rounded-lg px-3 py-2 border flex items-center justify-between z-10">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-lg" x-text="component.icon"></span>
                                        <span class="text-sm font-medium" x-text="component.name"></span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <button 
                                            @click.stop="moveComponent(index, 'up')"
                                            x-show="index > 0"
                                            class="p-1 text-gray-600 hover:text-blue-600 rounded"
                                            title="تحريك لأعلى">
                                            ⬆️
                                        </button>
                                        <button 
                                            @click.stop="moveComponent(index, 'down')"
                                            x-show="index < components.length - 1"
                                            class="p-1 text-gray-600 hover:text-blue-600 rounded"
                                            title="تحريك لأسفل">
                                            ⬇️
                                        </button>
                                        <button 
                                            @click.stop="duplicateComponent(component.id)"
                                            class="p-1 text-gray-600 hover:text-green-600 rounded"
                                            title="نسخ">
                                            📋
                                        </button>
                                        <button 
                                            @click.stop="editComponent(component.id)"
                                            class="p-1 text-gray-600 hover:text-yellow-600 rounded"
                                            title="تحرير">
                                            ✏️
                                        </button>
                                        <button 
                                            @click.stop="deleteComponent(component.id)"
                                            class="p-1 text-gray-600 hover:text-red-600 rounded"
                                            title="حذف">
                                            🗑️
                                        </button>
                                    </div>
                                </div>

                                <!-- Component Content -->
                                <div class="component-content">
                                    <template x-if="component.type === 'hero'">
                                        <div class="text-center py-16 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-lg">
                                            <h2 class="text-4xl font-bold mb-4" x-text="component.content.title || 'العنوان الرئيسي'"></h2>
                                            <p class="text-xl mb-6" x-text="component.content.subtitle || 'وصف مختصر عن محتوى الصفحة'"></p>
                                            <button class="px-8 py-3 bg-white text-blue-600 rounded-lg font-semibold hover:bg-gray-100"
                                                    x-show="component.content.button_text">
                                                <span x-text="component.content.button_text"></span>
                                            </button>
                                        </div>
                                    </template>

                                    <template x-if="component.type === 'text'">
                                        <div class="prose max-w-none p-4">
                                            <h3 x-text="component.content.heading || 'عنوان فرعي'"></h3>
                                            <p x-text="component.content.text || 'محتوى نصي يمكن تحريره حسب الحاجة'"></p>
                                        </div>
                                    </template>

                                    <template x-if="component.type === 'image'">
                                        <div class="text-center p-4">
                                            <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <span class="text-gray-500">📷 <span x-text="component.content.alt || 'بدون وصف'"></span></span>
                                            </div>
                                            <p class="text-sm text-gray-600 mt-2" x-show="component.content.caption" x-text="component.content.caption"></p>
                                        </div>
                                    </template>

                                    <template x-if="component.type === 'appointment_form'">
                                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                                            <h3 class="text-xl font-semibold mb-4 text-center">حجز موعد</h3>
                                            <form class="space-y-4">
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <input type="text" placeholder="الاسم الكامل" class="w-full px-3 py-2 border rounded">
                                                    <input type="email" placeholder="البريد الإلكتروني" class="w-full px-3 py-2 border rounded">
                                                    <input type="tel" placeholder="رقم الهاتف" class="w-full px-3 py-2 border rounded">
                                                    <input type="date" class="w-full px-3 py-2 border rounded">
                                                </div>
                                                <textarea placeholder="ملاحظات (اختياري)" class="w-full px-3 py-2 border rounded h-24"></textarea>
                                                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                                                    حجز الموعد
                                                </button>
                                            </form>
                                        </div>
                                    </template>

                                    <template x-if="component.type === 'custom_html'">
                                        <div class="bg-gray-50 p-4 rounded-lg border-2 border-dashed border-gray-300">
                                            <div class="flex items-center justify-between mb-2">
                                                <h3 class="font-medium text-gray-700">كود مخصص</h3>
                                                <span class="text-xs text-gray-500">HTML/CSS/JS</span>
                                            </div>
                                            <div class="bg-gray-900 text-green-400 p-3 rounded font-mono text-sm overflow-x-auto">
                                                <pre x-text="(component.content.html || 'كود HTML').substring(0, 100) + '...'"></pre>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Properties Panel -->
        <div class="w-80 bg-white border-l border-gray-200 flex flex-col" x-show="showProperties" style="display: none;">
            <div class="p-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold">خصائص المكون</h3>
                    <button @click="showProperties = false" class="text-gray-500 hover:text-gray-700">✕</button>
                </div>
            </div>
            
            <div class="flex-1 overflow-y-auto custom-scrollbar p-4">
                <template x-if="selectedComponent">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">اسم المكون</label>
                            <input 
                                x-model="selectedComponent.name"
                                type="text" 
                                class="w-full px-3 py-2 border border-gray-300 rounded text-sm">
                        </div>
                        
                        <template x-if="selectedComponent.type === 'hero'">
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">العنوان</label>
                                    <input 
                                        x-model="selectedComponent.content.title"
                                        type="text" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">العنوان الفرعي</label>
                                    <textarea 
                                        x-model="selectedComponent.content.subtitle"
                                        class="w-full px-3 py-2 border border-gray-300 rounded text-sm h-20"></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">نص الزر</label>
                                    <input 
                                        x-model="selectedComponent.content.button_text"
                                        type="text" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded text-sm">
                                </div>
                            </div>
                        </template>

                        <template x-if="selectedComponent.type === 'text'">
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">العنوان الفرعي</label>
                                    <input 
                                        x-model="selectedComponent.content.heading"
                                        type="text" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">المحتوى</label>
                                    <textarea 
                                        x-model="selectedComponent.content.text"
                                        class="w-full px-3 py-2 border border-gray-300 rounded text-sm h-32"></textarea>
                                </div>
                            </div>
                        </template>

                        <template x-if="selectedComponent.type === 'image'">
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">وصف الصورة</label>
                                    <input 
                                        x-model="selectedComponent.content.alt"
                                        type="text" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">شرح الصورة</label>
                                    <input 
                                        x-model="selectedComponent.content.caption"
                                        type="text" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded text-sm">
                                </div>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Custom HTML Modal -->
    <div x-show="showCustomHTMLModal" 
         class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center"
         style="display: none;">
        <div class="bg-white rounded-lg p-6 w-full max-w-4xl max-h-screen overflow-y-auto m-4">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold">إضافة كود مخصص</h3>
                <button @click="showCustomHTMLModal = false" class="text-gray-500 hover:text-gray-700 text-2xl">✕</button>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">HTML</label>
                    <textarea 
                        x-model="customHTML.html"
                        placeholder="<div>كود HTML هنا</div>"
                        class="w-full px-3 py-2 border rounded-lg h-64 font-mono text-sm resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">CSS</label>
                    <textarea 
                        x-model="customHTML.css"
                        placeholder=".my-class { color: red; }"
                        class="w-full px-3 py-2 border rounded-lg h-64 font-mono text-sm resize-none"></textarea>
                </div>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">JavaScript</label>
                <textarea 
                    x-model="customHTML.js"
                    placeholder="console.log('Hello World');"
                    class="w-full px-3 py-2 border rounded-lg h-32 font-mono text-sm resize-none"></textarea>
            </div>
            
            <div class="flex space-x-3">
                <button 
                    @click="addCustomHTML"
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                    إضافة الكود
                </button>
                <button 
                    @click="showCustomHTMLModal = false"
                    class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                    إلغاء
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Notifications -->
    <div x-show="showToast" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-x-full"
         x-transition:enter-end="opacity-100 transform translate-x-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 transform translate-x-0"
         x-transition:leave-end="opacity-0 transform translate-x-full"
         class="toast">
        <div class="bg-white rounded-lg shadow-lg border p-4 max-w-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium" x-text="toastMessage"></p>
                <button @click="showToast = false" class="text-gray-400 hover:text-gray-600 ml-3">✕</button>
            </div>
        </div>
    </div>

    <!-- Loading Spinner -->
    <div x-show="isLoading" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" style="display: none;">
        <div class="bg-white rounded-lg p-6 flex flex-col items-center">
            <div class="loading-spinner mb-4"></div>
            <p class="text-gray-600" x-text="loadingMessage"></p>
        </div>
    </div>

    <!-- Alpine.js Component Logic -->
    <script>
        function pageBuilder() {
            return {
                components: [],
                selectedComponent: null,
                pageTitle: '',
                pageSlug: '',
                previewMode: 'desktop',
                showProperties: false,
                showTemplates: false,
                showCustomHTMLModal: false,
                componentSearch: '',
                templates: [],
                isLoading: false,
                loadingMessage: '',
                showToast: false,
                toastMessage: '',
                
                customHTML: {
                    html: '',
                    css: '',
                    js: ''
                },

                availableComponents: [
                    // Layout Components
                    { id: 1, type: 'container', name: 'حاوية', icon: '📦', category: 'layout', content: { padding: '20px', background: 'transparent' } },
                    { id: 2, type: 'row', name: 'صف', icon: '📋', category: 'layout', content: { columns: 2 } },
                    { id: 3, type: 'column', name: 'عمود', icon: '📊', category: 'layout', content: { width: '50%' } },
                    
                    // Content Components
                    { id: 4, type: 'hero', name: 'قسم رئيسي', icon: '🌟', category: 'content', content: { title: 'العنوان الرئيسي', subtitle: 'وصف مختصر', button_text: 'احجز الآن' } },
                    { id: 5, type: 'text', name: 'نص', icon: '📝', category: 'content', content: { heading: 'عنوان فرعي', text: 'محتوى نصي يمكن تحريره' } },
                    { id: 6, type: 'image', name: 'صورة', icon: '🖼️', category: 'content', content: { alt: 'وصف الصورة', caption: 'شرح الصورة' } },
                    { id: 7, type: 'video', name: 'فيديو', icon: '🎥', category: 'content', content: { url: '', autoplay: false } },
                    
                    // UI Components
                    { id: 8, type: 'button', name: 'زر', icon: '🔘', category: 'ui', content: { text: 'نص الزر', style: 'primary', url: '#' } },
                    { id: 9, type: 'form', name: 'نموذج', icon: '📄', category: 'ui', content: { fields: [] } },
                    { id: 10, type: 'card', name: 'بطاقة', icon: '🃏', category: 'ui', content: { title: 'عنوان البطاقة', content: 'محتوى البطاقة' } },
                    { id: 11, type: 'table', name: 'جدول', icon: '📊', category: 'ui', content: { headers: [], rows: [] } },
                    
                    // Medical Components
                    { id: 12, type: 'appointment_form', name: 'نموذج حجز موعد', icon: '📅', category: 'medical', content: {} },
                    { id: 13, type: 'doctor_card', name: 'بطاقة طبيب', icon: '👨‍⚕️', category: 'medical', content: { name: 'د. أحمد محمد', specialty: 'أخصائي قلب', experience: '15 سنة خبرة' } },
                    { id: 14, type: 'service_list', name: 'قائمة الخدمات', icon: '⚕️', category: 'medical', content: { services: [] } },
                    { id: 15, type: 'testimonial', name: 'شهادة', icon: '💬', category: 'medical', content: { text: 'نص الشهادة', author: 'اسم المريض' } },
                    
                    // Interactive Components
                    { id: 16, type: 'accordion', name: 'أكورديون', icon: '📋', category: 'interactive', content: { items: [] } },
                    { id: 17, type: 'tabs', name: 'علامات التبويب', icon: '📑', category: 'interactive', content: { tabs: [] } },
                    { id: 18, type: 'carousel', name: 'عارض صور', icon: '🎠', category: 'interactive', content: { images: [] } },
                    { id: 19, type: 'modal', name: 'نافذة منبثقة', icon: '🪟', category: 'interactive', content: { title: 'عنوان النافذة', content: 'محتوى النافذة' } }
                ],

                init() {
                    this.loadTemplates();
                },

                getFilteredComponents(category) {
                    return this.availableComponents.filter(component => 
                        component.category === category &&
                        (!this.componentSearch || component.name.includes(this.componentSearch) || component.type.includes(this.componentSearch))
                    );
                },

                loadTemplates() {
                    // Load templates from API or static data
                    this.templates = [
                        { id: 1, name: 'الصفحة الرئيسية', description: 'قالب شامل للصفحة الرئيسية', category: 'home', is_premium: false },
                        { id: 2, name: 'صفحة الخدمات', description: 'قالب مخصص لعرض الخدمات الطبية', category: 'services', is_premium: true },
                        { id: 3, name: 'صفحة الحجز', description: 'نموذج حجز مواعيد محسن', category: 'booking', is_premium: false },
                        { id: 4, name: 'صفحة من نحن', description: 'قالب لمعلومات عن العيادة والفريق', category: 'about', is_premium: false }
                    ];
                },

                addComponent(type) {
                    const componentTemplate = this.availableComponents.find(c => c.type === type);
                    if (!componentTemplate) {
                        this.showToastMessage('خطأ: نوع المكون غير مدعوم', 'error');
                        return;
                    }

                    const newComponent = {
                        id: 'comp_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9),
                        type: type,
                        content: JSON.parse(JSON.stringify(componentTemplate.content)),
                        settings: {},
                        name: componentTemplate.name,
                        icon: componentTemplate.icon,
                        sort_order: this.components.length + 1
                    };

                    this.components.push(newComponent);
                    this.showToastMessage('تم إضافة المكون بنجاح', 'success');
                },

                deleteComponent(componentId) {
                    const index = this.components.findIndex(c => c.id === componentId);
                    if (index > -1) {
                        this.components.splice(index, 1);
                        this.showToastMessage('تم حذف المكون', 'success');
                    }
                },

                duplicateComponent(componentId) {
                    const component = this.components.find(c => c.id === componentId);
                    if (component) {
                        const duplicate = {
                            ...JSON.parse(JSON.stringify(component)),
                            id: 'comp_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9),
                            name: component.name + ' - نسخة'
                        };
                        
                        const index = this.components.findIndex(c => c.id === componentId);
                        this.components.splice(index + 1, 0, duplicate);
                        this.showToastMessage('تم نسخ المكون', 'success');
                    }
                },

                editComponent(componentId) {
                    this.selectedComponent = this.components.find(c => c.id === componentId);
                    this.showProperties = true;
                },

                selectComponent(componentId) {
                    this.selectedComponent = this.components.find(c => c.id === componentId);
                },

                moveComponent(index, direction) {
                    if (direction === 'up' && index > 0) {
                        [this.components[index], this.components[index - 1]] = 
                        [this.components[index - 1], this.components[index]];
                    } else if (direction === 'down' && index < this.components.length - 1) {
                        [this.components[index], this.components[index + 1]] = 
                        [this.components[index + 1], this.components[index]];
                    }
                },

                addCustomHTML() {
                    if (!this.customHTML.html.trim()) {
                        this.showToastMessage('يجب إدخال كود HTML', 'error');
                        return;
                    }

                    this.addComponent('custom_html');
                    const lastComponent = this.components[this.components.length - 1];
                    lastComponent.content = {
                        html: this.customHTML.html,
                        css: this.customHTML.css,
                        js: this.customHTML.js
                    };

                    this.showCustomHTMLModal = false;
                    this.customHTML = { html: '', css: '', js: '' };
                },

                loadTemplate(templateId) {
                    this.isLoading = true;
                    this.loadingMessage = 'جاري تحميل القالب...';
                    
                    setTimeout(() => {
                        // Simulate loading
                        const template = this.templates.find(t => t.id == templateId);
                        if (template) {
                            // Load template content based on template type
                            this.resetCanvas();
                            
                            if (template.category === 'home') {
                                this.addComponent('hero');
                                this.addComponent('text');
                                this.addComponent('appointment_form');
                            } else if (template.category === 'services') {
                                this.addComponent('hero');
                                this.addComponent('service_list');
                            } else if (template.category === 'booking') {
                                this.addComponent('hero');
                                this.addComponent('appointment_form');
                            }
                            
                            this.pageTitle = template.name;
                            this.pageSlug = template.name.toLowerCase().replace(/\s+/g, '-');
                            
                            this.showToastMessage('تم تحميل القالب بنجاح', 'success');
                        }
                        this.isLoading = false;
                        this.showTemplates = false;
                    }, 1000);
                },

                resetCanvas() {
                    this.components = [];
                    this.selectedComponent = null;
                    this.pageTitle = '';
                    this.pageSlug = '';
                    this.showProperties = false;
                },

                savePage() {
                    if (!this.pageTitle.trim()) {
                        this.showToastMessage('يجب إدخال عنوان الصفحة', 'error');
                        return;
                    }
                    
                    if (!this.pageSlug.trim()) {
                        this.pageSlug = this.pageTitle.toLowerCase().replace(/\s+/g, '-');
                    }

                    this.isLoading = true;
                    this.loadingMessage = 'جاري حفظ الصفحة...';

                    // Simulate save operation
                    setTimeout(() => {
                        const pageData = {
                            title: this.pageTitle,
                            slug: this.pageSlug,
                            components: this.components,
                            saved_at: new Date().toISOString()
                        };
                        
                        // Store in localStorage for demo
                        localStorage.setItem('saved_page_' + this.pageSlug, JSON.stringify(pageData));
                        
                        this.isLoading = false;
                        this.showToastMessage('تم حفظ الصفحة بنجاح', 'success');
                    }, 1500);
                },

                saveAsTemplate() {
                    if (!this.pageTitle.trim()) {
                        this.showToastMessage('يجب إدخال عنوان القالب', 'error');
                        return;
                    }

                    this.isLoading = true;
                    this.loadingMessage = 'جاري حفظ القالب...';

                    setTimeout(() => {
                        const templateData = {
                            name: this.pageTitle + ' - قالب',
                            slug: this.pageSlug + '_template',
                            components: this.components,
                            saved_at: new Date().toISOString()
                        };
                        
                        localStorage.setItem('saved_template_' + templateData.slug, JSON.stringify(templateData));
                        
                        this.isLoading = false;
                        this.showToastMessage('تم حفظ القالب بنجاح', 'success');
                    }, 1000);
                },

                previewPage() {
                    this.isLoading = true;
                    this.loadingMessage = 'جاري إنشاء المعاينة...';

                    setTimeout(() => {
                        this.isLoading = false;
                        this.showToastMessage('فتح صفحة المعاينة', 'info');
                        // In a real implementation, this would open a preview window
                        window.open('/preview-page', '_blank');
                    }, 1000);
                },

                exportPage() {
                    if (this.components.length === 0) {
                        this.showToastMessage('لا توجد مكونات للتصدير', 'error');
                        return;
                    }

                    const exportData = {
                        title: this.pageTitle,
                        slug: this.pageSlug,
                        components: this.components,
                        exported_at: new Date().toISOString(),
                        version: '1.0'
                    };

                    const dataStr = JSON.stringify(exportData, null, 2);
                    const dataBlob = new Blob([dataStr], {type: 'application/json'});
                    
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(dataBlob);
                    link.download = 'page_export_' + (this.pageSlug || 'untitled') + '_' + Date.now() + '.json';
                    link.click();

                    this.showToastMessage('تم تصدير الصفحة', 'success');
                },

                importPage() {
                    const input = document.createElement('input');
                    input.type = 'file';
                    input.accept = '.json';
                    
                    input.onchange = (event) => {
                        const file = event.target.files[0];
                        if (!file) return;

                        const reader = new FileReader();
                        reader.onload = (e) => {
                            try {
                                const data = JSON.parse(e.target.result);
                                this.components = data.components || [];
                                this.pageTitle = data.title || '';
                                this.pageSlug = data.slug || '';
                                this.showToastMessage('تم استيراد الصفحة بنجاح', 'success');
                            } catch (error) {
                                this.showToastMessage('خطأ في قراءة الملف', 'error');
                            }
                        };
                        reader.readAsText(file);
                    };
                    
                    input.click();
                },

                setPreviewMode(mode) {
                    this.previewMode = mode;
                    // Update canvas max-width based on mode
                    const canvas = document.querySelector('.canvas-container');
                    if (canvas) {
                        canvas.className = `canvas-container ${mode === 'desktop' ? 'max-w-4xl' : mode === 'tablet' ? 'max-w-2xl' : 'max-w-sm'} mx-auto`;
                    }
                },

                showToastMessage(message, type = 'info') {
                    this.toastMessage = message;
                    this.showToast = true;
                    
                    setTimeout(() => {
                        this.showToast = false;
                    }, 3000);
                }
            }
        }
    </script>
</body>
</html>