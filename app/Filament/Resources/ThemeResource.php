<?php

namespace App\Filament\Resources\ThemeResource;

use App\Filament\Resources\ThemeResource\Pages;
use App\Models\Theme;
use Filament\Resources\Resource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Infolists\Infolist;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\ImageEntry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ThemeResource extends Resource
{
    protected static ?string $model = Theme::class;

    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';

    protected static ?string $navigationLabel = 'إدارة الثيمات';

    protected static ?string $modelLabel = 'ثيم';

    protected static ?string $pluralModelLabel = 'الثيمات';

    protected static ?string $navigationGroup = 'التخصيص والثيمات';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    /**
     * Create record
     */
    public static function createRecord(): CreateRecord
    {
        return new CreateRecord;
    }

    /**
     * Table configuration
     */
    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('اسم الثيم')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold),
                
                Tables\Columns\TextColumn::make('description')
                    ->label('الوصف')
                    ->limit(50)
                    ->searchable(),
                
                Tables\Columns\ImageColumn::make('preview_image')
                    ->label('صورة المعاينة')
                    ->square()
                    ->disk('public'),
                
                Tables\Columns\TextColumn::make('author')
                    ->label('المؤلف')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('version')
                    ->label('الإصدار')
                    ->badge()
                    ->color('gray'),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('مفعل')
                    ->boolean()
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('is_default')
                    ->label('افتراضي')
                    ->boolean()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('layout_type')
                    ->label('نوع التخطيط')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'full-width' => 'عرض كامل',
                        'boxed' => 'صندوق',
                        'split' => 'مقسم',
                        default => $state,
                    }),
                
                Tables\Columns\TextColumn::make('color_scheme')
                    ->label('نظام الألوان')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'blue' => 'primary',
                        'green' => 'success',
                        'purple' => 'warning',
                        'red' => 'danger',
                        default => 'gray',
                    }),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('مفعل'),
                
                Tables\Filters\TernaryFilter::make('is_default')
                    ->label('افتراضي'),
                
                Tables\Filters\SelectFilter::make('layout_type')
                    ->label('نوع التخطيط')
                    ->options([
                        'full-width' => 'عرض كامل',
                        'boxed' => 'صندوق',
                        'split' => 'مقسم',
                    ]),
                
                Tables\Filters\SelectFilter::make('color_scheme')
                    ->label('نظام الألوان')
                    ->options([
                        'blue' => 'أزرق',
                        'green' => 'أخضر',
                        'purple' => 'بنفسجي',
                        'red' => 'أحمر',
                        'custom' => 'مخصص',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('preview')
                    ->label('معاينة')
                    ->icon('heroicon-m-eye')
                    ->color('info')
                    ->url(fn (Theme $record): string => route('theme.preview', $record))
                    ->openUrlInNewTab(),
                
                Tables\Actions\Action::make('activate')
                    ->label('تفعيل')
                    ->icon('heroicon-m-check-circle')
                    ->color('success')
                    ->visible(fn (Theme $record): bool => !$record->is_active)
                    ->requiresConfirmation()
                    ->modalHeading('تفعيل الثيم')
                    ->modalDescription('هل تريد تفعيل هذا الثيم؟ سيتم إلغاء تفعيل الثيم الحالي.')
                    ->action(function (Theme $record) {
                        $record->activate();
                        $record->setAsDefault();
                        
                        // Update theme application
                        static::applyTheme($record);
                    }),
                
                Tables\Actions\EditAction::make()
                    ->label('تعديل')
                    ->mutateFormDataBeforeSaveUsing(function (array $data): array {
                        // Ensure only one default theme
                        if ($data['is_default'] ?? false) {
                            Theme::where('id', '!=', $data['id'])->update(['is_default' => false]);
                        }
                        
                        // Generate slug if not provided
                        if (empty($data['slug'])) {
                            $data['slug'] = Theme::generateSlug($data['name']);
                        }
                        
                        return $data;
                    }),
                
                Tables\Actions\Action::make('duplicate')
                    ->label('نسخ')
                    ->icon('heroicon-m-document-duplicate')
                    ->color('warning')
                    ->form([
                        \Filament\Forms\Components\TextInput::make('name')
                            ->label('اسم الثيم الجديد')
                            ->required()
                            ->default(fn (Theme $record): string => $record->name . ' (نسخة)'),
                    ])
                    ->action(function (Theme $record, array $data) {
                        $duplicate = $record->duplicate($data['name']);
                        
                        // Copy media files
                        foreach ($record->getMedia() as $media) {
                            $duplicate->addMedia($media->getPath())->toMediaCollection($media->collection_name);
                        }
                        
                        static::notify('success', 'تم نسخ الثيم بنجاح');
                    }),
                
                Tables\Actions\Action::make('export')
                    ->label('تصدير')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->color('primary')
                    ->action(function (Theme $record) {
                        $exportData = $record->export();
                        
                        return response()->streamDownload(function () use ($exportData) {
                            echo $exportData;
                        }, $record->slug . '.json');
                    }),
                
                Tables\Actions\DeleteAction::make()
                    ->label('حذف')
                    ->visible(fn (Theme $record): bool => !$record->is_default)
                    ->requiresConfirmation()
                    ->modalHeading('حذف الثيم')
                    ->modalDescription('هل أنت متأكد من حذف هذا الثيم؟ لا يمكن التراجع عن هذا الإجراء.'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('activate_bulk')
                        ->label('تفعيل المحدد')
                        ->icon('heroicon-m-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('تفعيل الثيمات')
                        ->modalDescription('هل تريد تفعيل هذه الثيمات؟ سيتم إلغاء تفعيل باقي الثيمات.')
                        ->action(function ($records) {
                            DB::transaction(function () use ($records) {
                                // Deactivate all themes first
                                Theme::where('id', '!=', $records->first()->id)->update(['is_active' => false]);
                                
                                // Activate selected theme
                                $records->first()->update(['is_active' => true]);
                                
                                static::applyTheme($records->first());
                            });
                        }),
                    
                    Tables\Actions\BulkAction::make('export_bulk')
                        ->label('تصدير المحدد')
                        ->icon('heroicon-m-arrow-down-tray')
                        ->color('primary')
                        ->action(function ($records) {
                            $exports = [];
                            foreach ($records as $record) {
                                $exports[] = [
                                    'name' => $record->name,
                                    'data' => $record->export()
                                ];
                            }
                            
                            $jsonData = json_encode($exports, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                            
                            return response()->streamDownload(function () use ($jsonData) {
                                echo $jsonData;
                            }, 'themes-export-' . date('Y-m-d') . '.json');
                        }),
                    
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('حذف المحدد')
                        ->visible(fn ($records): bool => $records->where('is_default', true)->isEmpty())
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('is_default', 'desc')
            ->poll('30s');
    }

    /**
     * InfoList configuration
     */
    public static function infoList(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('المعلومات الأساسية')
                            ->schema([
                                TextEntry::make('name')
                                    ->label('اسم الثيم')
                                    ->size(TextEntry\TextEntrySize::Large)
                                    ->weight(FontWeight::Bold),
                                
                                TextEntry::make('description')
                                    ->label('الوصف')
                                    ->size(TextEntry\TextEntrySize::Medium),
                                
                                TextEntry::make('author')
                                    ->label('المؤلف'),
                                
                                TextEntry::make('version')
                                    ->label('الإصدار')
                                    ->badge()
                                    ->color('gray'),
                                
                                TextEntry::make('layout_type')
                                    ->label('نوع التخطيط')
                                    ->badge()
                                    ->formatStateUsing(fn (string $state): string => match ($state) {
                                        'full-width' => 'عرض كامل',
                                        'boxed' => 'صندوق',
                                        'split' => 'مقسم',
                                        default => $state,
                                    }),
                                
                                TextEntry::make('color_scheme')
                                    ->label('نظام الألوان')
                                    ->badge()
                                    ->formatStateUsing(fn (string $state): string => match ($state) {
                                        'blue' => 'أزرق',
                                        'green' => 'أخضر',
                                        'purple' => 'بنفسجي',
                                        'red' => 'أحمر',
                                        'custom' => 'مخصص',
                                        default => $state,
                                    }),
                            ]),
                        
                        Tabs\Tab::make('إعدادات متقدمة')
                            ->schema([
                                Section::make('إعدادات التخطيط')
                                    ->schema([
                                        TextEntry::make('settings')
                                            ->label('الإعدادات')
                                            ->formatStateUsing(fn (array $state): string => json_encode($state, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT))
                                            ->markdown()
                                            ->columnSpan(2),
                                    ]),
                                
                                Section::make('الطباعة')
                                    ->schema([
                                        TextEntry::make('typography')
                                            ->label('إعدادات الخط')
                                            ->formatStateUsing(fn (array $state): string => json_encode($state, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT))
                                            ->markdown()
                                            ->columnSpan(2),
                                    ]),
                                
                                Section::make('معلومات النظام')
                                    ->schema([
                                        TextEntry::make('is_active')
                                            ->label('مفعل')
                                            ->boolean(),
                                        
                                        TextEntry::make('is_default')
                                            ->label('افتراضي')
                                            ->boolean(),
                                        
                                        TextEntry::make('created_at')
                                            ->label('تاريخ الإنشاء')
                                            ->dateTime(),
                                        
                                        TextEntry::make('updated_at')
                                            ->label('تاريخ آخر تحديث')
                                            ->dateTime(),
                                    ]),
                            ]),
                        
                        Tabs\Tab::make('الملفات المرفقة')
                            ->schema([
                                ImageEntry::make('preview_image')
                                    ->label('صورة المعاينة')
                                    ->disk('public')
                                    ->height(200)
                                    ->width(300),
                                
                                ImageEntry::make('background_image')
                                    ->label('صورة الخلفية')
                                    ->disk('public')
                                    ->height(200)
                                    ->width(300),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    /**
     * Apply theme to application
     */
    public static function applyTheme(Theme $theme)
    {
        // Update application settings with theme
        $settings = app('settings');
        $settings->update([
            'current_theme' => $theme->slug,
            'theme_settings' => $theme->settings,
            'theme_colors' => $theme->color_scheme,
            'layout_type' => $theme->layout_type
        ]);
        
        // Generate theme-specific CSS
        $theme->generateThemeFile();
    }

    /**
     * Get pages
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListThemes::route('/'),
            'create' => Pages\CreateTheme::route('/create'),
            'edit' => Pages\EditTheme::route('/{record}/edit'),
            'preview' => Pages\PreviewTheme::route('/{record}/preview'),
            'builder' => Pages\ThemeBuilder::route('/{record}/builder'),
        ];
    }

    /**
     * Can create
     */
    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_themes') ?? false;
    }

    /**
     * Can edit
     */
    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->can('edit_themes') ?? false;
    }

    /**
     * Can delete
     */
    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->can('delete_themes') ?? false && !$record->is_default;
    }
}