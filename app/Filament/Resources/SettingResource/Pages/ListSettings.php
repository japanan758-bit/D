<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Builder;

class ListSettings extends ListRecords
{
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Only allow creating if no settings exist
            Actions\CreateAction::make()
                ->visible(fn () => Setting::count() === 0),
        ];
    }
}
