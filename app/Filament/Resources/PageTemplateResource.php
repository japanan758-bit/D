<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageTemplateResource\Pages;
use App\Models\PageTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;

class PageTemplateResource extends Resource
{
    protected static ?string $model = PageTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?string $navigationLabel = 'إدارة الصفحات';

    protected static ?string $modelLabel = 'صفحة';

    protected static ?string $pluralModelLabel = 'الصفحات والقوالب';

    protected static ?string $navigationGroup = 'التخصيص والثيمات';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('اسم الصفحة')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->label('الرابط المختصر')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\Select::make('category')
                    ->label('الفئة')
                    ->options([
                        'custom' => 'مخصص',
                        'home' => 'رئيسية',
                        'about' => 'من نحن',
                        'services' => 'خدمات',
                        'contact' => 'اتصال',
                    ])
                    ->default('custom'),
                Forms\Components\Textarea::make('description')
                    ->label('الوصف')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')
                    ->label('مفعل')
                    ->default(true),
                Forms\Components\Toggle::make('is_premium')
                    ->label('مميز')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('الرابط')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('الفئة')
                    ->badge(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('مفعل')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'custom' => 'مخصص',
                        'home' => 'رئيسية',
                        'about' => 'من نحن',
                        'services' => 'خدمات',
                        'contact' => 'اتصال',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('open_builder')
                    ->label('فتح المحرر')
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning')
                    ->url(fn (PageTemplate $record): string => route('page-builder.edit', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListPageTemplates::route('/'),
            'create' => Pages\CreatePageTemplate::route('/create'),
            'edit' => Pages\EditPageTemplate::route('/{record}/edit'),
        ];
    }
}
