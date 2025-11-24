<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Theme;
use App\Models\PageTemplate;
use App\Models\PageBuilderComponent;
use Illuminate\Support\Facades\Auth;

class PageBuilder extends Component
{
    public $currentTheme;
    public $components = [];
    public $selectedComponent = null;
    public $editingComponent = null;
    public $componentCounter = 0;
    public $previewMode = 'desktop';
    public $draggedComponent = null;
    public $availableComponents = [];
    public $pageTitle = '';
    public $pageSlug = '';
    public $showComponentSettings = false;
    public $unsavedChanges = false;

    protected $listeners = [
        'componentAdded' => 'addComponent',
        'componentUpdated' => 'updateComponent',
        'componentDeleted' => 'deleteComponent',
        'componentReordered' => 'reorderComponents',
        'savePage' => 'savePage',
        'previewPage' => 'previewPage',
    ];

    public function mount($themeId = null, $pageId = null)
    {
        $this->currentTheme = $themeId ? Theme::find($themeId) : Theme::active();
        $this->loadAvailableComponents();
        $this->loadPageComponents($pageId);
    }

    public function render()
    {
        return view('livewire.page-builder');
    }

    public function loadAvailableComponents()
    {
        $this->availableComponents = PageBuilderComponent::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    public function loadPageComponents($pageId = null)
    {
        if ($pageId) {
            $page = PageTemplate::find($pageId);
            if ($page) {
                $this->components = json_decode($page->content, true) ?? [];
                $this->pageTitle = $page->name;
                $this->pageSlug = $page->slug;
            }
        } else {
            // Load default components for new page
            $this->components = [];
        }
    }

    public function addComponent($componentType, $insertIndex = null)
    {
        $componentTemplate = $this->availableComponents->where('type', $componentType)->first();
        
        if (!$componentTemplate) {
            $this->dispatch('showToast', type: 'error', message: 'مكون غير مدعوم');
            return;
        }

        $newComponent = [
            'id' => 'comp_' . (++$this->componentCounter),
            'type' => $componentType,
            'content' => $componentTemplate->default_content ?? [],
            'settings' => $componentTemplate->schema ?? [],
            'name' => $componentTemplate->name,
            'icon' => $componentTemplate->icon,
            'sort_order' => count($this->components) + 1,
        ];

        if ($insertIndex !== null) {
            array_splice($this->components, $insertIndex, 0, [$newComponent]);
            $this->updateSortOrders();
        } else {
            $this->components[] = $newComponent;
        }

        $this->markAsUnsaved();
        $this->dispatch('showToast', type: 'success', message: 'تم إضافة المكون بنجاح');
    }

    public function deleteComponent($componentId)
    {
        $index = collect($this->components)->search(function ($component) use ($componentId) {
            return $component['id'] === $componentId;
        });

        if ($index !== false) {
            array_splice($this->components, $index, 1);
            $this->updateSortOrders();
            $this->markAsUnsaved();
            $this->dispatch('showToast', type: 'success', message: 'تم حذف المكون');
        }
    }

    public function duplicateComponent($componentId)
    {
        $originalIndex = collect($this->components)->search(function ($component) use ($componentId) {
            return $component['id'] === $componentId;
        });

        if ($originalIndex !== false) {
            $originalComponent = $this->components[$originalIndex];
            $duplicateComponent = array_merge($originalComponent, [
                'id' => 'comp_' . (++$this->componentCounter),
                'name' => $originalComponent['name'] . ' - نسخة',
            ]);
            
            array_splice($this->components, $originalIndex + 1, 0, [$duplicateComponent]);
            $this->updateSortOrders();
            $this->markAsUnsaved();
            $this->dispatch('showToast', type: 'success', message: 'تم نسخ المكون');
        }
    }

    public function updateComponent($componentId, $updates)
    {
        $index = collect($this->components)->search(function ($component) use ($componentId) {
            return $component['id'] === $componentId;
        });

        if ($index !== false) {
            $this->components[$index] = array_merge($this->components[$index], $updates);
            $this->markAsUnsaved();
            $this->dispatch('componentUpdated', componentId: $componentId);
        }
    }

    public function reorderComponents($draggedId, $targetId, $position)
    {
        $draggedIndex = collect($this->components)->search(function ($component) use ($draggedId) {
            return $component['id'] === $draggedId;
        });

        $targetIndex = collect($this->components)->search(function ($component) use ($targetId) {
            return $component['id'] === $targetId;
        });

        if ($draggedIndex !== false && $targetIndex !== false) {
            $draggedComponent = $this->components[$draggedIndex];
            
            // Remove dragged component
            array_splice($this->components, $draggedIndex, 1);
            
            // Calculate new index
            $newIndex = $targetIndex;
            if ($position === 'after') {
                $newIndex++;
            }
            
            // Insert at new position
            array_splice($this->components, $newIndex, 0, [$draggedComponent]);
            $this->updateSortOrders();
            $this->markAsUnsaved();
        }
    }

    private function updateSortOrders()
    {
        foreach ($this->components as $index => $component) {
            $this->components[$index]['sort_order'] = $index + 1;
        }
    }

    public function selectComponent($componentId)
    {
        $this->selectedComponent = $this->components->where('id', $componentId)->first();
    }

    public function editComponent($componentId)
    {
        $this->editingComponent = $componentId;
        $this->showComponentSettings = true;
    }

    public function closeComponentSettings()
    {
        $this->editingComponent = null;
        $this->showComponentSettings = false;
    }

    public function updateComponentContent($componentId, $content)
    {
        $index = collect($this->components)->search(function ($component) use ($componentId) {
            return $component['id'] === $componentId;
        });

        if ($index !== false) {
            $this->components[$index]['content'] = $content;
            $this->markAsUnsaved();
            $this->dispatch('componentUpdated', componentId: $componentId);
        }
    }

    public function setPreviewMode($mode)
    {
        $this->previewMode = $mode;
    }

    public function savePage()
    {
        $this->validate([
            'pageTitle' => 'required|string|max:255',
            'pageSlug' => 'required|string|max:255|unique:page_templates,slug',
        ]);

        $pageData = [
            'name' => $this->pageTitle,
            'slug' => $this->pageSlug,
            'description' => 'صفحة مخصصة تم إنشاؤها باستخدام Page Builder',
            'content' => json_encode($this->components),
            'category' => 'custom',
            'is_premium' => false,
            'is_active' => true,
        ];

        PageTemplate::create($pageData);
        $this->unsavedChanges = false;
        
        $this->dispatch('showToast', type: 'success', message: 'تم حفظ الصفحة بنجاح');
    }

    public function saveAsTemplate()
    {
        $templateName = $this->pageTitle . ' - قالب';
        
        PageTemplate::create([
            'name' => $templateName,
            'slug' => str_slug($templateName),
            'description' => 'قالب مخصص تم إنشاؤه من Page Builder',
            'content' => json_encode($this->components),
            'category' => 'custom',
            'is_premium' => true,
            'is_active' => true,
        ]);

        $this->dispatch('showToast', type: 'success', message: 'تم حفظ القالب بنجاح');
    }

    public function exportPage()
    {
        $pageData = [
            'title' => $this->pageTitle,
            'slug' => $this->pageSlug,
            'components' => $this->components,
            'exported_at' => now()->toISOString(),
        ];

        return response()->download(
            storage_path('app/temp/page_export_' . time() . '.json'),
            'page_export_' . $this->pageSlug . '.json'
        );
    }

    public function importPage($importedData)
    {
        if (isset($importedData['components'])) {
            $this->components = $importedData['components'];
            $this->pageTitle = $importedData['title'] ?? '';
            $this->pageSlug = $importedData['slug'] ?? '';
            $this->updateSortOrders();
            $this->markAsUnsaved();
            $this->dispatch('showToast', type: 'success', message: 'تم استيراد الصفحة بنجاح');
        }
    }

    public function resetPage()
    {
        $this->components = [];
        $this->pageTitle = '';
        $this->pageSlug = '';
        $this->selectedComponent = null;
        $this->editingComponent = null;
        $this->componentCounter = 0;
        $this->unsavedChanges = false;
    }

    public function loadTemplate($templateId)
    {
        $template = PageTemplate::find($templateId);
        if ($template) {
            $this->components = json_decode($template->content, true) ?? [];
            $this->pageTitle = $template->name;
            $this->pageSlug = $template->slug . '_copy_' . time();
            $this->updateSortOrders();
            $this->markAsUnsaved();
            $this->dispatch('showToast', type: 'success', message: 'تم تحميل القالب بنجاح');
        }
    }

    public function markAsUnsaved()
    {
        $this->unsavedChanges = true;
    }

    public function getComponentIcon($type)
    {
        $component = $this->availableComponents->where('type', $type)->first();
        return $component ? $component->icon : 'heroicon-o-rectangle';
    }

    public function getComponentTitle($type)
    {
        $component = $this->availableComponents->where('type', $type)->first();
        return $component ? $component->name : $type;
    }

    public function canMoveUp($component)
    {
        return $component['sort_order'] > 1;
    }

    public function canMoveDown($component)
    {
        return $component['sort_order'] < count($this->components);
    }

    public function moveUp($componentId)
    {
        $index = collect($this->components)->search(function ($component) use ($componentId) {
            return $component['id'] === $componentId;
        });

        if ($index > 0) {
            [$this->components[$index], $this->components[$index - 1]] = 
            [$this->components[$index - 1], $this->components[$index]];
            $this->updateSortOrders();
            $this->markAsUnsaved();
        }
    }

    public function moveDown($componentId)
    {
        $index = collect($this->components)->search(function ($component) use ($componentId) {
            return $component['id'] === $componentId;
        });

        if ($index < count($this->components) - 1) {
            [$this->components[$index], $this->components[$index + 1]] = 
            [$this->components[$index + 1], $this->components[$index]];
            $this->updateSortOrders();
            $this->markAsUnsaved();
        }
    }

    public function addCustomHTML($html, $css = '', $js = '')
    {
        $customComponent = [
            'id' => 'comp_' . (++$this->componentCounter),
            'type' => 'custom_html',
            'content' => [
                'html' => $html,
                'css' => $css,
                'js' => $js,
            ],
            'settings' => [],
            'name' => 'كود مخصص',
            'icon' => 'heroicon-o-code-bracket',
            'sort_order' => count($this->components) + 1,
        ];

        $this->components[] = $customComponent;
        $this->markAsUnsaved();
        $this->dispatch('showToast', type: 'success', message: 'تم إضافة الكود المخصص');
    }

    public function duplicateMultiple($componentIds)
    {
        foreach ($componentIds as $componentId) {
            $this->duplicateComponent($componentId);
        }
    }

    public function deleteMultiple($componentIds)
    {
        foreach ($componentIds as $componentId) {
            $this->deleteComponent($componentId);
        }
    }
}