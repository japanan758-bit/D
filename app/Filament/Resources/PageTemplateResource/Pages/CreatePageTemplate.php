<?php

namespace App\Filament\Resources\PageTemplateResource\Pages;

use App\Filament\Resources\PageTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePageTemplate extends CreateRecord
{
    protected static string $resource = PageTemplateResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirect to page builder after creation
        return route('page-builder.edit', $this->record);
    }
}
