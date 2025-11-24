<?php

namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Resources\ContactMessageResource;
use Filament\Resources\Pages\EditRecord;

class EditContactMessage extends EditRecord
{
    protected static string $resource = ContactMessageResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Set replied_at when a reply is provided
        if (!empty($data['reply']) && !$this->record->has_reply) {
            $data['replied_at'] = now();
        }
        
        return $data;
    }
}