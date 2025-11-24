<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestAppointments extends BaseWidget
{
    protected static ?int $sort = 3;

    protected static ?string $heading = 'أحدث المواعيد';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Appointment::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('patient_name')
                    ->label('المريض'),
                Tables\Columns\TextColumn::make('doctor.name')
                    ->label('الطبيب'),
                Tables\Columns\TextColumn::make('appointment_date')
                    ->label('التاريخ')
                    ->date(),
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge(),
            ])
            ->actions([
                 //
            ]);
    }
}
