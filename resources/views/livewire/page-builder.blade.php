<div>
    <!-- Header Section -->
    <div class="bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <h1 class="text-xl font-bold text-gray-900">محرر الصفحات - Page Builder</h1>
            @if($unsavedChanges)
                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded">
                    ✏️ تغييرات غير محفوظة
                </span>
            @endif
        </div>
        
        <div class="flex items-center space-x-2">
            <!-- Preview Mode Toggle -->
            <div class="flex bg-gray-100 rounded-lg p-1">
                <button 
                    @click="setPreviewMode('desktop')" 
                    class="px-3 py-1 text-sm rounded {{ $previewMode === 'desktop' ? 'bg-white shadow-sm' : '' }}"
                    :class="$previewMode === 'desktop' ? 'text-blue-600' : 'text-gray-600'">
                    💻 سطح المكتب
                </button>
                <button 
                    @click="setPreviewMode('tablet')" 
                    class="px-3 py-1 text-sm rounded {{ $previewMode === 'tablet' ? 'bg-white shadow-sm' : '' }}"
                    :class="$previewMode === 'tablet' ? 'text-blue-600' : 'text-gray-600'">
                    📱 الجهاز اللوحي
                </button>
                <button 
                    @click="setPreviewMode('mobile')" 
                    class="px-3 py-1 text-sm rounded {{ $previewMode === 'mobile' ? 'bg-white shadow-sm' : '' }}"
                    :class="$previewMode === 'mobile' ? 'text-blue-600' : 'text-gray-600'">
                    📱 الجوال
                </button>
            </div>

            <!-- Save Actions -->
            <div class="flex space-x-2">
                <button 
                    wire:click="savePage" 
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm font-medium">
                    💾 حفظ الصفحة
                </button>
                <button 
                    wire:click="saveAsTemplate" 
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium">
                    ⭐ حفظ كقالب
                </button>
                <button 
                    wire:click="previewPage" 
                    class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 text-sm font-medium">
                    👁️ معاينة
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="flex h-screen">
        <!-- Component Library Sidebar -->
        <div class="w-80 bg-gray-50 border-r border-gray-200 overflow-y-auto">
            <div class="p-4">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">📚 مكتبة المكونات</h2>
                
                <!-- Search Components -->
                <div class="mb-4">
                    <input 
                        type="text" 
                        placeholder="البحث في المكونات..." 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                        x-model="componentSearch">
                </div>

                <!-- Component Categories -->
                <div class="space-y-3">
                    <!-- Layout Components -->
                    <div class="border border-gray-200 rounded-lg">
                        <div class="bg-gray-100 px-3 py-2 rounded-t-lg">
                            <h3 class="font-medium text-gray-700 text-sm">🎨 تخطيط</h3>
                        </div>
                        <div class="p-2 grid grid-cols-2 gap-2">
                            @foreach($availableComponents->where('type', 'container')->values() as $component)
                            <div 
                                draggable="true" 
                                @dragstart="startDrag($event, '{{ $component->type }}')"
                                class="p-3 bg-white border border-gray-200 rounded cursor-move hover:shadow-md transition-shadow">
                                <div class="text-center">
                                    <div class="text-2xl mb-1">{{ $component->icon }}</div>
                                    <div class="text-xs font-medium text-gray-700">{{ $component->name }}</div>
                                </div>
                            </div>
                            @endforeach

                            <div 
                                draggable="true" 
                                @dragstart="startDrag($event, 'custom_html')"
                                class="p-3 bg-white border border-gray-200 rounded cursor-move hover:shadow-md transition-shadow">
                                <div class="text-center">
                                    <div class="text-2xl mb-1">💻</div>
                                    <div class="text-xs font-medium text-gray-700">كود مخصص</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Components -->
                    <div class="border border-gray-200 rounded-lg">
                        <div class="bg-gray-100 px-3 py-2 rounded-t-lg">
                            <h3 class="font-medium text-gray-700 text-sm">📝 محتوى</h3>
                        </div>
                        <div class="p-2 grid grid-cols-2 gap-2">
                            @foreach($availableComponents->whereIn('type', ['text', 'image', 'video'])->values() as $component)
                            <div 
                                draggable="true" 
                                @dragstart="startDrag($event, '{{ $component->type }}')"
                                class="p-3 bg-white border border-gray-200 rounded cursor-move hover:shadow-md transition-shadow">
                                <div class="text-center">
                                    <div class="text-2xl mb-1">{{ $component->icon }}</div>
                                    <div class="text-xs font-medium text-gray-700">{{ $component->name }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- UI Components -->
                    <div class="border border-gray-200 rounded-lg">
                        <div class="bg-gray-100 px-3 py-2 rounded-t-lg">
                            <h3 class="font-medium text-gray-700 text-sm">🧩 واجهة مستخدم</h3>
                        </div>
                        <div class="p-2 grid grid-cols-2 gap-2">
                            @foreach($availableComponents->whereIn('type', ['button', 'form', 'card', 'table'])->values() as $component)
                            <div 
                                draggable="true" 
                                @dragstart="startDrag($event, '{{ $component->type }}')"
                                class="p-3 bg-white border border-gray-200 rounded cursor-move hover:shadow-md transition-shadow">
                                <div class="text-center">
                                    <div class="text-2xl mb-1">{{ $component->icon }}</div>
                                    <div class="text-xs font-medium text-gray-700">{{ $component->name }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Medical Components -->
                    <div class="border border-gray-200 rounded-lg">
                        <div class="bg-gray-100 px-3 py-2 rounded-t-lg">
                            <h3 class="font-medium text-gray-700 text-sm">⚕️ طبي</h3>
                        </div>
                        <div class="p-2 grid grid-cols-2 gap-2">
                            @foreach($availableComponents->whereIn('type', ['appointment_form', 'doctor_card', 'service_list', 'testimonial'])->values() as $component)
                            <div 
                                draggable="true" 
                                @dragstart="startDrag($event, '{{ $component->type }}')"
                                class="p-3 bg-white border border-gray-200 rounded cursor-move hover:shadow-md transition-shadow">
                                <div class="text-center">
                                    <div class="text-2xl mb-1">{{ $component->icon }}</div>
                                    <div class="text-xs font-medium text-gray-700">{{ $component->name }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Interactive Components -->
                    <div class="border border-gray-200 rounded-lg">
                        <div class="bg-gray-100 px-3 py-2 rounded-t-lg">
                            <h3 class="font-medium text-gray-700 text-sm">🎯 تفاعلي</h3>
                        </div>
                        <div class="p-2 grid grid-cols-2 gap-2">
                            @foreach($availableComponents->whereIn('type', ['accordion', 'tabs', 'carousel', 'modal'])->values() as $component)
                            <div 
                                draggable="true" 
                                @dragstart="startDrag($event, '{{ $component->type }}')"
                                class="p-3 bg-white border border-gray-200 rounded cursor-move hover:shadow-md transition-shadow">
                                <div class="text-center">
                                    <div class="text-2xl mb-1">{{ $component->icon }}</div>
                                    <div class="text-xs font-medium text-gray-700">{{ $component->name }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Canvas Area -->
        <div class="flex-1 bg-gray-100 relative">
            <!-- Page Settings Bar -->
            <div class="bg-white border-b border-gray-200 p-3">
                <div class="flex items-center space-x-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700">عنوان الصفحة</label>
                        <input 
                            type="text" 
                            wire:model.debounce.300ms="pageTitle" 
                            class="mt-1 block w-64 px-3 py-1 border border-gray-300 rounded text-sm"
                            placeholder="عنوان الصفحة">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700">الرابط</label>
                        <input 
                            type="text" 
                            wire:model.debounce.300ms="pageSlug" 
                            class="mt-1 block w-48 px-3 py-1 border border-gray-300 rounded text-sm"
                            placeholder="my-page">
                    </div>
                </div>
            </div>

            <!-- Canvas -->
            <div 
                class="p-6 h-full overflow-y-auto"
                :class="{
                    'max-w-4xl mx-auto': $previewMode === 'desktop',
                    'max-w-2xl mx-auto': $previewMode === 'tablet',
                    'max-w-sm mx-auto': $previewMode === 'mobile'
                }"
                @drop="handleDrop"
                @dragover.prevent
                @dragenter.prevent>

                <!-- Empty State -->
                @if(count($components) === 0)
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-12 text-center">
                        <div class="text-6xl mb-4">🎨</div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">ابدأ بإنشاء صفحتك</h3>
                        <p class="text-gray-600 mb-4">اسحب وأفلت المكونات من الشريط الجانبي لبناء صفحتك المثالية</p>
                        <button 
                            wire:click="addComponent('hero')"
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                            إضافة قسم رئيسي
                        </button>
                    </div>
                @endif

                <!-- Components List -->
                <div class="space-y-4">
                    @foreach($components as $index => $component)
                    <div 
                        wire:key="component-{{ $component['id'] }}"
                        class="group relative"
                        draggable="true"
                        @dragstart="startComponentDrag($event, '{{ $component['id'] }}')"
                        @drop="handleComponentDrop($event, '{{ $component['id'] }}')"
                        @dragover.prevent
                        @dragenter.prevent>

                        <!-- Component Toolbar -->
                        <div class="absolute -top-10 left-0 right-0 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                            <div class="flex items-center justify-between bg-white shadow-lg rounded-lg px-3 py-2 border">
                                <div class="flex items-center space-x-2">
                                    <span class="text-lg">{{ $component['icon'] ?? '📦' }}</span>
                                    <span class="font-medium text-sm">{{ $component['name'] }}</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    @if($this->canMoveUp($component))
                                    <button 
                                        wire:click="moveUp('{{ $component['id'] }}')"
                                        class="p-1 text-gray-600 hover:text-blue-600 rounded"
                                        title="تحريك لأعلى">
                                        ⬆️
                                    </button>
                                    @endif
                                    
                                    @if($this->canMoveDown($component))
                                    <button 
                                        wire:click="moveDown('{{ $component['id'] }}')"
                                        class="p-1 text-gray-600 hover:text-blue-600 rounded"
                                        title="تحريك لأسفل">
                                        ⬇️
                                    </button>
                                    @endif
                                    
                                    <button 
                                        wire:click="duplicateComponent('{{ $component['id'] }}')"
                                        class="p-1 text-gray-600 hover:text-green-600 rounded"
                                        title="نسخ">
                                        📋
                                    </button>
                                    
                                    <button 
                                        wire:click="editComponent('{{ $component['id'] }}')"
                                        class="p-1 text-gray-600 hover:text-yellow-600 rounded"
                                        title="تحرير">
                                        ✏️
                                    </button>
                                    
                                    <button 
                                        wire:click="deleteComponent('{{ $component['id'] }}')"
                                        class="p-1 text-gray-600 hover:text-red-600 rounded"
                                        title="حذف">
                                        🗑️
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Component Content -->
                        <div class="border border-gray-300 rounded-lg bg-white p-4 hover:shadow-md transition-shadow">
                            <!-- Hero Component -->
                            @if($component['type'] === 'hero')
                                <div class="text-center py-16 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-lg">
                                    <h2 class="text-4xl font-bold mb-4">{{ $component['content']['title'] ?? 'العنوان الرئيسي' }}</h2>
                                    <p class="text-xl mb-6">{{ $component['content']['subtitle'] ?? 'وصف مختصر عن محتوى الصفحة' }}</p>
                                    @if(isset($component['content']['button_text']))
                                    <button class="px-8 py-3 bg-white text-blue-600 rounded-lg font-semibold hover:bg-gray-100">
                                        {{ $component['content']['button_text'] }}
                                    </button>
                                    @endif
                                </div>
                            
                            <!-- Text Component -->
                            @elseif($component['type'] === 'text')
                                <div class="prose max-w-none">
                                    <h3>{{ $component['content']['heading'] ?? 'عنوان فرعي' }}</h3>
                                    <p>{{ $component['content']['text'] ?? 'محتوى نصي يمكن تحريره حسب الحاجة' }}</p>
                                </div>
                            
                            <!-- Image Component -->
                            @elseif($component['type'] === 'image')
                                <div class="text-center">
                                    <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <span class="text-gray-500">📷 الصورة - {{ $component['content']['alt'] ?? 'بدون وصف' }}</span>
                                    </div>
                                    @if(isset($component['content']['caption']))
                                    <p class="text-sm text-gray-600 mt-2">{{ $component['content']['caption'] }}</p>
                                    @endif
                                </div>
                            
                            <!-- Appointment Form Component -->
                            @elseif($component['type'] === 'appointment_form')
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
                            
                            <!-- Custom HTML Component -->
                            @elseif($component['type'] === 'custom_html')
                                <div class="bg-gray-50 p-4 rounded-lg border-2 border-dashed border-gray-300">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="font-medium text-gray-700">كود مخصص</h3>
                                        <span class="text-xs text-gray-500">HTML/CSS/JS</span>
                                    </div>
                                    <div class="bg-gray-900 text-green-400 p-3 rounded font-mono text-sm overflow-x-auto">
                                        <pre>{{ Str::limit($component['content']['html'] ?? 'كود HTML', 100) }}</pre>
                                    </div>
                                </div>
                            
                            <!-- Default Component Display -->
                            @else
                                <div class="bg-gray-100 p-4 rounded border border-gray-200 text-center">
                                    <div class="text-2xl mb-2">{{ $component['icon'] ?? '📦' }}</div>
                                    <h3 class="font-medium text-gray-700">{{ $component['name'] }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">{{ $component['type'] }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Drop Zone Indicator -->
                        <div class="absolute inset-0 border-2 border-dashed border-transparent hover:border-blue-400 rounded-lg transition-colors pointer-events-none"></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Properties Panel -->
        @if($showComponentSettings && $editingComponent)
        <div class="w-80 bg-white border-l border-gray-200 overflow-y-auto">
            <div class="p-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">خصائص المكون</h3>
                    <button 
                        wire:click="closeComponentSettings"
                        class="text-gray-500 hover:text-gray-700">
                        ✕
                    </button>
                </div>

                @php
                    $component = $components->firstWhere('id', $editingComponent);
                @endphp

                @if($component)
                    <!-- Component Content Editor -->
                    <div class="space-y-4">
                        @if($component['type'] === 'hero')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">العنوان</label>
                                <input 
                                    type="text" 
                                    wire:model.debounce.300ms="components.{{ $loop->index }}.content.title"
                                    class="w-full px-3 py-2 border border-gray-300 rounded text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">العنوان الفرعي</label>
                                <textarea 
                                    wire:model.debounce.300ms="components.{{ $loop->index }}.content.subtitle"
                                    class="w-full px-3 py-2 border border-gray-300 rounded text-sm h-20"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">نص الزر</label>
                                <input 
                                    type="text" 
                                    wire:model.debounce.300ms="components.{{ $loop->index }}.content.button_text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded text-sm">
                            </div>
                        
                        @elseif($component['type'] === 'text')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">العنوان الفرعي</label>
                                <input 
                                    type="text" 
                                    wire:model.debounce.300ms="components.{{ $loop->index }}.content.heading"
                                    class="w-full px-3 py-2 border border-gray-300 rounded text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">المحتوى</label>
                                <textarea 
                                    wire:model.debounce.300ms="components.{{ $loop->index }}.content.text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded text-sm h-32"></textarea>
                            </div>
                        
                        @elseif($component['type'] === 'image')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">وصف الصورة (Alt Text)</label>
                                <input 
                                    type="text" 
                                    wire:model.debounce.300ms="components.{{ $loop->index }}.content.alt"
                                    class="w-full px-3 py-2 border border-gray-300 rounded text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">شرح الصورة</label>
                                <input 
                                    type="text" 
                                    wire:model.debounce.300ms="components.{{ $loop->index }}.content.caption"
                                    class="w-full px-3 py-2 border border-gray-300 rounded text-sm">
                            </div>
                        
                        @elseif($component['type'] === 'custom_html')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">HTML</label>
                                <textarea 
                                    wire:model.debounce.300ms="components.{{ $loop->index }}.content.html"
                                    class="w-full px-3 py-2 border border-gray-300 rounded text-sm h-32 font-mono text-xs"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">CSS</label>
                                <textarea 
                                    wire:model.debounce.300ms="components.{{ $loop->index }}.content.css"
                                    class="w-full px-3 py-2 border border-gray-300 rounded text-sm h-24 font-mono text-xs"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">JavaScript</label>
                                <textarea 
                                    wire:model.debounce.300ms="components.{{ $loop->index }}.content.js"
                                    class="w-full px-3 py-2 border border-gray-300 rounded text-sm h-24 font-mono text-xs"></textarea>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- Custom HTML Modal -->
    <div x-data="{ showCustomHTML: false, html: '', css: '', js: '' }" x-show="showCustomHTML" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" style="display: none;">
        <div class="bg-white rounded-lg p-6 w-full max-w-4xl max-h-screen overflow-y-auto">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">إضافة كود مخصص</h3>
                <button @click="showCustomHTML = false" class="text-gray-500 hover:text-gray-700">✕</button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">HTML</label>
                    <textarea x-model="html" class="w-full px-3 py-2 border rounded h-64 font-mono text-sm"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">CSS</label>
                    <textarea x-model="css" class="w-full px-3 py-2 border rounded h-64 font-mono text-sm"></textarea>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">JavaScript</label>
                <textarea x-model="js" class="w-full px-3 py-2 border rounded h-32 font-mono text-sm"></textarea>
            </div>
            
            <div class="flex space-x-2">
                <button 
                    @click="$wire.addCustomHTML(html, css, js); showCustomHTML = false"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    إضافة الكود
                </button>
                <button 
                    @click="showCustomHTML = false"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                    إلغاء
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Notifications -->
    <div x-data="{ show: false, message: '', type: 'info' }" 
         x-show="show" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-x-full"
         x-transition:enter-end="opacity-100 transform translate-x-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 transform translate-x-0"
         x-transition:leave-end="opacity-0 transform translate-x-full"
         class="fixed top-4 right-4 z-50">
        <div class="bg-white rounded-lg shadow-lg border p-4 max-w-sm">
            <div class="flex items-center">
                <div class="flex-1">
                    <p x-text="message" class="text-sm font-medium"></p>
                </div>
                <button @click="show = false" class="text-gray-400 hover:text-gray-600">✕</button>
            </div>
        </div>
    </div>

    <!-- Alpine.js Script -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('pageBuilder', () => ({
                draggedComponent: null,
                draggedElement: null,
                previewMode: @this.previewMode,

                startDrag(event, componentType) {
                    this.draggedComponent = componentType;
                    event.dataTransfer.effectAllowed = 'copy';
                    event.dataTransfer.setData('text/plain', componentType);
                },

                startComponentDrag(event, componentId) {
                    this.draggedElement = componentId;
                    event.dataTransfer.effectAllowed = 'move';
                    event.dataTransfer.setData('text/component', componentId);
                },

                handleDrop(event) {
                    event.preventDefault();
                    const componentType = event.dataTransfer.getData('text/plain');
                    if (componentType && componentType !== 'custom_html') {
                        @this.addComponent(componentType);
                    } else if (componentType === 'custom_html') {
                        this.$dispatch('show-custom-html-modal');
                    }
                    this.draggedComponent = null;
                },

                handleComponentDrop(event, targetId) {
                    event.preventDefault();
                    const draggedId = event.dataTransfer.getData('text/component');
                    if (draggedId && draggedId !== targetId) {
                        // Determine if dropped before or after target
                        const rect = event.currentTarget.getBoundingClientRect();
                        const isAfter = (event.clientY - rect.top) > rect.height / 2;
                        @this.reorderComponents(draggedId, targetId, isAfter ? 'after' : 'before');
                    }
                    this.draggedElement = null;
                },

                setPreviewMode(mode) {
                    this.previewMode = mode;
                    @this.setPreviewMode(mode);
                },

                showToast(type, message) {
                    this.$dispatch('show-toast', { type, message });
                }
            }));
        });

        // Custom Event Listeners
        window.addEventListener('showToast', (event) => {
            const toast = document.querySelector('[x-data="pageBuilder"]');
            if (toast) {
                toast.__x.$data.show = true;
                toast.__x.$data.message = event.detail.message;
                toast.__x.$data.type = event.detail.type;
                
                setTimeout(() => {
                    toast.__x.$data.show = false;
                }, 3000);
            }
        });
    </script>
</div>