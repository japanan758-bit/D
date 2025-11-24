<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationLabel = 'شهادات المرضى';

    protected static ?string $modelLabel = 'شهادة';

    protected static ?string $pluralModelLabel = 'شهادات المرضى';

    protected static ?string $navigationGroup = 'المحتوى';

    protected static ?int $navigationSort = 5;

    public static function form(Tables\Table $table): array
    {
        return $table
            ->recordTitleAttribute('patient_name')
            ->columns([
                Tables\Columns\TextColumn::make('patient_name')
                    ->label('اسم المريض')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('service.name')
                    ->label('الخدمة')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rating')
                    ->label('التقييم')
                    ->formatStateUsing(fn (int $state): string => str_repeat('⭐', $state))
                    ->sortable(),
                Tables\Columns\TextColumn::make('comment')
                    ->label('التعليق')
                    ->limit(50),
                Tables\Columns\IconColumn::make('is_approved')
                    ->label('موافق عليه')
                    ->boolean(),
                Tables\Columns\TextColumn::make('is_featured')
                    ->label('مميز')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_approved')
                    ->label('حالة الموافقة'),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('شهادات مميزة'),
                Tables\Filters\SelectFilter::make('service_id')
                    ->label('الخدمة')
                    ->relationship('service', 'name'),
                Tables\Filters\SelectFilter::make('rating')
                    ->label('التقييم')
                    ->options([
                        5 => '5 نجوم',
                        4 => '4 نجوم',
                        3 => '3 نجوم',
                        2 => '2 نجمة',
                        1 => '1 نجمة',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('موافقة')
                    ->label('موافقة')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn (Model $record): bool => !$record->is_approved)
                    ->action(fn (Model $record) => $record->update(['is_approved' => true])),
                Tables\Actions\Action::make('رفض')
                    ->label('رفض')
                    ->icon('heroicon-o-x')
                    ->color('danger')
                    ->visible(fn (Model $record): bool => $record->is_approved)
                    ->action(fn (Model $record) => $record->update(['is_approved' => false])),
                Tables\Actions\Action::make('تمييز')
                    ->label('تمييز')
                    ->icon('heroicon-o-star')
                    ->color('warning')
                    ->visible(fn (Model $record): bool => !$record->is_featured)
                    ->action(fn (Model $record) => $record->update(['is_featured' => true])),
                Tables\Actions\EditAction::make()
                    ->label('تعديل'),
                Tables\Actions\DeleteAction::make()
                    ->label('حذف'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('موافقة المحدد')
                        ->label('موافقة المحدد')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['is_approved' => true])),
                    Tables\Actions\BulkAction::make('تمييز المحدد')
                        ->label('تمييز المحدد')
                        ->icon('heroicon-o-star')
                        ->color('warning')
                        ->action(fn ($records) => $records->each->update(['is_featured' => true])),
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('حذف المحدد'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}