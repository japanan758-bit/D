<?php

namespace App\Filament\Resources\MedicalRecordResource\Pages;

use App\Filament\Resources\MedicalRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMedicalRecord extends CreateRecord
{
    protected static string $resource = MedicalRecordResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
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
}
