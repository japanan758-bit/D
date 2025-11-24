<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationLabel = 'المواعيد';

    protected static ?string $modelLabel = 'موعد';

    protected static ?string $pluralModelLabel = 'المواعيد';

    protected static ?string $navigationGroup = 'إدارة المواعيد';

    protected static ?int $navigationSort = 3;

    public static function form(Tables\Table $table): array
    {
        // Placeholder for form method signature fix if needed, but actually we are editing table()
        return $table
            ->recordTitleAttribute('patient_name')
            ->columns([
                Tables\Columns\TextColumn::make('patient_name')
                    ->label('اسم المريض')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('patient_phone')
                    ->label('رقم الهاتف')
                    ->searchable(),
                Tables\Columns\TextColumn::make('service.name')
                    ->label('الخدمة')
                    ->searchable(),
                Tables\Columns\TextColumn::make('appointment_date')
                    ->label('تاريخ الموعد')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'معلق',
                        'confirmed' => 'مؤكد',
                        'completed' => 'مكتمل',
                        'cancelled' => 'ملغي',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'completed' => 'info',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('notes')
                    ->label('ملاحظات')
                    ->limit(30),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('الحالة')
                    ->options([
                        'pending' => 'معلق',
                        'confirmed' => 'مؤكد',
                        'completed' => 'مكتمل',
                        'cancelled' => 'ملغي',
                    ]),
                Tables\Filters\TernaryFilter::make('is_urgent')
                    ->label('عاجل'),
                Tables\Filters\DateFilter::make('appointment_date')
                    ->label('تاريخ الموعد'),
                Tables\Filters\SelectFilter::make('service_id')
                    ->label('الخدمة')
                    ->relationship('service', 'name'),
            ])
            ->actions([
                Tables\Actions\Action::make('تأكيد')
                    ->label('تأكيد')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Model $record): bool => $record->status === 'pending')
                    ->action(fn (Model $record) => $record->update(['status' => 'confirmed'])),
                Tables\Actions\Action::make('إكمال')
                    ->label('إكمال')
                    ->icon('heroicon-o-check')
                    ->color('info')
                    ->visible(fn (Model $record): bool => in_array($record->status, ['confirmed', 'pending']))
                    ->action(fn (Model $record) => $record->update(['status' => 'completed'])),
                Tables\Actions\Action::make('إلغاء')
                    ->label('إلغاء')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (Model $record): bool => !in_array($record->status, ['cancelled', 'completed']))
                    ->action(fn (Model $record) => $record->update(['status' => 'cancelled'])),
                Tables\Actions\EditAction::make()
                    ->label('تعديل'),
                Tables\Actions\DeleteAction::make()
                    ->label('حذف'),
            ])
            ->headerActions([
                // Simple CSV Export Action using pure PHP stream
                Tables\Actions\Action::make('export')
                    ->label('تصدير CSV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function () {
                        $appointments = Appointment::with(['service', 'doctor'])->get();
                        $filename = 'appointments-' . date('Y-m-d') . '.csv';

                        return response()->streamDownload(function () use ($appointments) {
                            $handle = fopen('php://output', 'w');
                            fputcsv($handle, ['ID', 'Patient Name', 'Phone', 'Service', 'Doctor', 'Date', 'Status']);

                            foreach ($appointments as $appointment) {
                                fputcsv($handle, [
                                    $appointment->id,
                                    $appointment->patient_name,
                                    $appointment->patient_phone,
                                    $appointment->service->name ?? '',
                                    $appointment->doctor->name ?? '',
                                    $appointment->appointment_date,
                                    $appointment->status
                                ]);
                            }
                            fclose($handle);
                        }, $filename);
                    })
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('تأكيد المحدد')
                        ->label('تأكيد المحدد')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['status' => 'confirmed'])),
                    Tables\Actions\BulkAction::make('إلغاء المحدد')
                        ->label('إلغاء المحدد')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(fn ($records) => $records->each->update(['status' => 'cancelled'])),
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('حذف المحدد'),
                ]),
            ])
            ->defaultSort('appointment_date', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }

    // Add explicit export logic here if not using pxlrbt/filament-excel
    // Filament 3 has native Export actions which can be added to the table header.

    public static function canViewAny(): bool
    {
        return Auth::check();
    }
}