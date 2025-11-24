<?php

namespace App\Filament\Resources\MedicalRecordResource\Pages;

use App\Filament\Resources\MedicalRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMedicalRecord extends EditRecord
{
    protected static string $resource = MedicalRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['medications_data'])) {
            $medications = [];
            $dosages = [];
            $frequencies = [];
            $durations = [];

            foreach ($data['medications_data'] as $item) {
                $medications[] = $item['name'];
                $dosages[] = $item['dosage'];
                $frequencies[] = $item['frequency'];
                $durations[] = $item['duration'];
            }

            // No need to json_encode because model casts handle array conversion
            $data['medications'] = $medications;
            $data['dosages'] = $dosages;
            $data['frequencies'] = $frequencies;
            $data['durations'] = $durations;

            unset($data['medications_data']);
        }

        return $data;
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Data is already an array due to model casting
        $medications = $data['medications'] ?? [];
        $dosages = $data['dosages'] ?? [];
        $frequencies = $data['frequencies'] ?? [];
        $durations = $data['durations'] ?? [];

        // Handle case where data might still be string (legacy records)
        if (is_string($medications)) $medications = json_decode($medications, true) ?? [];
        if (is_string($dosages)) $dosages = json_decode($dosages, true) ?? [];
        if (is_string($frequencies)) $frequencies = json_decode($frequencies, true) ?? [];
        if (is_string($durations)) $durations = json_decode($durations, true) ?? [];

        $medicationsData = [];
        foreach ($medications as $index => $name) {
            $medicationsData[] = [
                'name' => $name,
                'dosage' => $dosages[$index] ?? '',
                'frequency' => $frequencies[$index] ?? '',
                'duration' => $durations[$index] ?? '',
            ];
        }

        $data['medications_data'] = $medicationsData;

        return $data;
    }
}
