<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationLabel = 'رسائل التواصل';

    protected static ?string $modelLabel = 'رسالة';

    protected static ?string $pluralModelLabel = 'رسائل التواصل';

    protected static ?string $navigationGroup = 'التواصل';

    protected static ?int $navigationSort = 7;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Tables\Table $table): array
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('البريد الإلكتروني')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('رقم الهاتف')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject')
                    ->label('الموضوع')
                    ->searchable(),
                Tables\Columns\TextColumn::make('message')
                    ->label('الرسالة')
                    ->limit(50),
                Tables\Columns\IconColumn::make('is_read')
                    ->label('مقروءة')
                    ->boolean(),
                Tables\Columns\TextColumn::make('replied_at')
                    ->label('تاريخ الرد')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإرسال')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_read')
                    ->label('حالة القراءة'),
                Tables\Filters\TernaryFilter::make('has_reply')
                    ->label('مستجابة')
                    ->query(fn ($query) => $query->whereNotNull('reply'))
                    ->placeholder('الكل')
                    ->trueLabel('تم الرد عليها')
                    ->falseLabel('لم يتم الرد عليها'),
                Tables\Filters\DateFilter::make('created_at')
                    ->label('تاريخ الإرسال'),
            ])
            ->actions([
                Tables\Actions\Action::make('عرض')
                    ->label('عرض')
                    ->icon('heroicon-o-eye')
                    ->modalHeading(fn (Model $record): string => "رسالة من {$record->name}")
                    ->modalContent(fn (Model $record): string => "
                        <div class='space-y-4'>
                            <div>
                                <strong>اسم المرسل:</strong> {$record->name}
                            </div>
                            <div>
                                <strong>البريد الإلكتروني:</strong> {$record->email}
                            </div>
                            <div>
                                <strong>رقم الهاتف:</strong> {$record->phone}
                            </div>
                            <div>
                                <strong>الموضوع:</strong> {$record->subject}
                            </div>
                            <div>
                                <strong>الرسالة:</strong>
                                <p class='mt-2 p-3 bg-gray-50 rounded'>{$record->message}</p>
                            </div>
                            " . ($record->reply ? "<div><strong>الرد:</strong><p class='mt-2 p-3 bg-blue-50 rounded'>{$record->reply}</p></div>" : "") . "
                        </div>
                    ")
                    ->action(fn (Model $record) => $record->update(['is_read' => true])),
                Tables\Actions\EditAction::make()
                    ->label('رد')
                    ->visible(fn (Model $record): bool => !$record->has_reply),
                Tables\Actions\DeleteAction::make()
                    ->label('حذف'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('تمييز كمقروءة')
                        ->label('تمييز كمقروءة')
                        ->icon('heroicon-o-check')
                        ->action(fn ($records) => $records->each->update(['is_read' => true])),
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
            'index' => Pages\ListContactMessages::route('/'),
            'create' => Pages\CreateContactMessage::route('/create'),
            'edit' => Pages\EditContactMessage::route('/{record}/edit'),
        ];
    }
}