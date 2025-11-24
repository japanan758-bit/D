<?php

namespace App\Filament\Resources\ThemeResource\Pages;

use App\Filament\Resources\ThemeResource;
use Filament\Resources\Pages\Page;
use App\Models\Theme;
use App\Models\PageBuilderComponent;
use App\Models\PageTemplate;

class ThemeBuilder extends Page
{
    protected static string $resource = ThemeResource::class;

    protected static string $view = 'filament.resources.theme-resource.pages.theme-builder';

    public Theme $record;

    public function mount($record)
    {
        $this->record = Theme::findOrFail($record);
    }

    public function getTitle(): string
    {
        return 'محرر الثيم: ' . $this->record->name;
    }

    protected function getViewData(): array
    {
        return [
            'theme' => $this->record,
            'components' => PageBuilderComponent::where('is_active', true)->get(),
            'templates' => PageTemplate::where('is_active', true)->get(),
        ];
    }
}
