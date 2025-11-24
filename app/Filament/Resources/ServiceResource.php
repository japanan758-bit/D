<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'الخدمات الطبية';

    protected static ?string $modelLabel = 'خدمة طبية';

    protected static ?string $pluralModelLabel = 'الخدمات الطبية';

    protected static ?string $navigationGroup = 'إدارة العيادة';

    protected static ?int $navigationSort = 2;

    public static function form(Tables\Table $table): array
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('اسم الخدمة')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('الوصف')
                    ->limit(50),
                Tables\Columns\TextColumn::make('price')
                    ->label('السعر')
                    ->money('EGP')
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration')
                    ->label('المدة (دقيقة)')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('نشطة')
                    ->boolean(),
                Tables\Columns\TextColumn::make('appointments_count')
                    ->label('عدد المواعيد')
                    ->counts('appointments'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('حالة النشاط'),
                Tables\Filters\SelectFilter::make('category')
                    ->label('الفئة')
                    ->options(Service::distinct()->pluck('category', 'category')),
                Tables\Filters\NumericFilter::make('price')
                    ->label('السعر')
                    ->numeric(),
            ])
            ->actions([
                Tables\Actions\Action::make('عرض')
                    ->label('عرض')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Model $record): string => static::getUrl('view', ['record' => $record])),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}