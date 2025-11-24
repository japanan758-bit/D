<?php

namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Resources\ContactMessageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContactMessage extends CreateRecord
{
    protected static string $resource = ContactMessageResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Set default values
        $data['is_read'] = false;
        
        return $data;
    }
}