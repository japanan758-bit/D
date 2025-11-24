<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-8-tooth';

    protected static ?string $navigationLabel = 'الإعدادات';

    protected static ?string $modelLabel = 'إعداد';

    protected static ?string $pluralModelLabel = 'الإعدادات';

    protected static ?string $navigationGroup = 'إدارة النظام';

    protected static ?int $navigationSort = 8;

    protected static ?string $recordTitleAttribute = 'key';

    public static function form(Tables\Table $table): array
    {
        return $table
            ->recordTitleAttribute('key')
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('المفتاح')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('القيمة')
                    ->limit(50),
                Tables\Columns\TextColumn::make('type')
                    ->label('النوع')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'text' => 'نص',
                        'textarea' => 'نص طويل',
                        'number' => 'رقم',
                        'email' => 'بريد إلكتروني',
                        'url' => 'رابط',
                        'boolean' => 'نعم/لا',
                        'image' => 'صورة',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('group')
                    ->label('المجموعة')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('الوصف')
                    ->limit(50),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('النوع')
                    ->options([
                        'text' => 'نص',
                        'textarea' => 'نص طويل',
                        'number' => 'رقم',
                        'email' => 'بريد إلكتروني',
                        'url' => 'رابط',
                        'boolean' => 'نعم/لا',
                        'image' => 'صورة',
                    ]),
                Tables\Filters\SelectFilter::make('group')
                    ->label('المجموعة')
                    ->options(Setting::distinct()->pluck('group', 'group')),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('تعديل'),
                Tables\Actions\DeleteAction::make()
                    ->label('حذف'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('حذف المحدد'),
                ]),
            ])
            ->defaultSort('group', 'asc');
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_settings') ?? false;
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->can('edit_settings') ?? false;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->can('delete_settings') ?? false;
    }
}