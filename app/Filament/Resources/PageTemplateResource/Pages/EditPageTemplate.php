<?php

namespace App\Filament\Resources\PageTemplateResource\Pages;

use App\Filament\Resources\PageTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPageTemplate extends EditRecord
{
    protected static string $resource = PageTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('open_builder')
                ->label('فتح المحرر')
                ->icon('heroicon-o-pencil-square')
                ->color('warning')
                ->url(fn (): string => route('page-builder.edit', $this->record))
                ->openUrlInNewTab(),
        ];
    }
}
