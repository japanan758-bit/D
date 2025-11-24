<?php

namespace App\Filament\Resources\ThemeResource\Pages;

use App\Filament\Resources\ThemeResource;
use App\Models\Theme;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Colors\Color;
use Illuminate\Database\Eloquent\Model;

class ListThemes extends ListRecords
{
    protected static string $resource = ThemeResource::class;

    public function getTitle(): string
    {
        return 'إدارة الثيمات';
    }

    /**
     * Get table actions
     */
    public function getHeaderActions(): array
    {
        return [
            Actions\Action::make('create')
                ->label('إنشاء ثيم جديد')
                ->icon('heroicon-m-plus-circle')
                ->url(fn (): string => static::getResource()::getUrl('create')),
            
            Actions\Action::make('import')
                ->label('استيراد ثيم')
                ->icon('heroicon-m-arrow-up-tray')
                ->color('info')
                ->form([
                    \Filament\Forms\Components\FileUpload::make('theme_file')
                        ->label('ملف الثيم')
                        ->required()
                        ->acceptedFileTypes(['application/json', 'text/json'])
                        ->helperText('قم بتحميل ملف JSON الخاص بالثيم'),
                    \Filament\Forms\Components\TextInput::make('theme_name')
                        ->label('اسم الثيم')
                        ->helperText('اتركه فارغاً لاستخدام اسم الثيم من الملف'),
                ])
                ->action(function (array $data) {
                    if (isset($data['theme_file']) && $data['theme_file']->isValid()) {
                        $jsonContent = file_get_contents($data['theme_file']->getPath());
                        $name = $data['theme_name'] ?? null;
                        
                        try {
                            $theme = Theme::importFromJson($jsonContent, $name);
                            
                            // Copy uploaded file to media collection
                            if ($theme) {
                                $theme->addMedia($data['theme_file']->getPath())->toMediaCollection('theme_assets');
                            }
                            
                            static::notify('success', 'تم استيراد الثيم بنجاح');
                        } catch (\Exception $e) {
                            static::notify('error', 'فشل في استيراد الثيم: ' . $e->getMessage());
                        }
                    }
                }),
            
            Actions\Action::make('export_all')
                ->label('تصدير جميع الثيمات')
                ->icon('heroicon-m-arrow-down-tray')
                ->color('primary')
                ->action(function () {
                    $themes = Theme::all();
                    $exports = [];
                    
                    foreach ($themes as $theme) {
                        $exports[] = [
                            'name' => $theme->name,
                            'data' => $theme->export()
                        ];
                    }
                    
                    $jsonData = json_encode($exports, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                    
                    return response()->streamDownload(function () use ($jsonData) {
                        echo $jsonData;
                    }, 'themes-export-' . date('Y-m-d') . '.json');
                }),
        ];
    }

    /**
     * Get table columns
     */
    public function table(Tables\Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('preview_image')
                    ->label('المعاينة')
                    ->square()
                    ->size(60)
                    ->disk('public')
                    ->defaultImageUrl('/images/default-theme.png'),
                
                Tables\Columns\TextColumn::make('name')
                    ->label('اسم الثيم')
                    ->searchable()
                    ->sortable()
                    ->weight(\Filament\Support\Enums\FontWeight::Bold)
                    ->wrap(),
                
                Tables\Columns\TextColumn::make('description')
                    ->label('الوصف')
                    ->limit(50)
                    ->wrap(),
                
                Tables\Columns\TextColumn::make('author')
                    ->label('المؤلف')
                    ->searchable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('version')
                    ->label('الإصدار')
                    ->badge()
                    ->color('gray'),
                
                Tables\Columns\TextColumn::make('layout_type')
                    ->label('التخطيط')
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
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'blue' => 'أزرق',
                        'green' => 'أخضر',
                        'purple' => 'بنفسجي',
                        'red' => 'أحمر',
                        'custom' => 'مخصص',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'blue' => 'primary',
                        'green' => 'success',
                        'purple' => 'warning',
                        'red' => 'danger',
                        'custom' => 'gray',
                        default => 'gray',
                    }),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('مفعل')
                    ->boolean()
                    ->sortable()
                    ->alignCenter(),
                
                Tables\Columns\IconColumn::make('is_default')
                    ->label('افتراضي')
                    ->boolean()
                    ->sortable()
                    ->alignCenter(),
                
                Tables\Columns\TextColumn::make('animations_enabled')
                    ->label('حركات')
                    ->boolean()
                    ->alignCenter(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('حالة التفعيل')
                    ->placeholder('الكل')
                    ->trueLabel('مفعل')
                    ->falseLabel('غير مفعل'),
                
                Tables\Filters\TernaryFilter::make('is_default')
                    ->label('الثيم الافتراضي')
                    ->placeholder('الكل')
                    ->trueLabel('افتراضي')
                    ->falseLabel('غير افتراضي'),
                
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
                
                Tables\Filters\TernaryFilter::make('animations_enabled')
                    ->label('الرسوم المتحركة')
                    ->placeholder('الكل')
                    ->trueLabel('مفعلة')
                    ->falseLabel('غير مفعلة'),
            ])
            ->actions([
                Tables\Actions\Action::make('preview')
                    ->label('معاينة')
                    ->icon('heroicon-m-eye')
                    ->color('info')
                    ->size('sm')
                    ->url(fn (Theme $record): string => route('theme.preview', $record))
                    ->openUrlInNewTab(),
                
                Tables\Actions\Action::make('activate')
                    ->label('تفعيل')
                    ->icon('heroicon-m-check-circle')
                    ->color('success')
                    ->size('sm')
                    ->visible(fn (Theme $record): bool => !$record->is_active)
                    ->requiresConfirmation()
                    ->modalHeading('تفعيل الثيم')
                    ->modalDescription('هل تريد تفعيل هذا الثيم؟ سيتم إلغاء تفعيل الثيم الحالي.')
                    ->modalSubmitActionLabel('تفعيل')
                    ->modalCancelActionLabel('إلغاء')
                    ->action(function (Theme $record) {
                        // Deactivate all themes first
                        Theme::where('id', '!=', $record->id)->update(['is_active' => false]);
                        
                        // Activate this theme
                        $record->update(['is_active' => true]);
                        
                        // Set as default if not already
                        if (!$record->is_default) {
                            $record->setAsDefault();
                        }
                        
                        // Apply theme
                        $this->applyTheme($record);
                        
                        static::notify('success', 'تم تفعيل الثيم بنجاح');
                    }),
                
                Tables\Actions\Action::make('set_default')
                    ->label('تعيين كافتراضي')
                    ->icon('heroicon-m-star')
                    ->color('warning')
                    ->size('sm')
                    ->visible(fn (Theme $record): bool => !$record->is_default && $record->is_active)
                    ->requiresConfirmation()
                    ->modalHeading('تعيين الثيم الافتراضي')
                    ->modalDescription('هل تريد تعيين هذا الثيم كالثيم الافتراضي للموقع؟')
                    ->modalSubmitActionLabel('تعيين')
                    ->modalCancelActionLabel('إلغاء')
                    ->action(function (Theme $record) {
                        $record->setAsDefault();
                        
                        // Apply theme
                        $this->applyTheme($record);
                        
                        static::notify('success', 'تم تعيين الثيم كافتراضي بنجاح');
                    }),
                
                Tables\Actions\EditAction::make()
                    ->label('تعديل')
                    ->icon('heroicon-m-pencil')
                    ->color('primary')
                    ->size('sm'),
                
                Tables\Actions\Action::make('builder')
                    ->label('محرر')
                    ->icon('heroicon-m-swatch')
                    ->color('warning')
                    ->size('sm')
                    ->url(fn (Theme $record): string => route('theme.builder', $record)),
                
                Tables\Actions\Action::make('duplicate')
                    ->label('نسخ')
                    ->icon('heroicon-m-document-duplicate')
                    ->color('secondary')
                    ->size('sm')
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
                    ->size('sm')
                    ->action(function (Theme $record) {
                        $exportData = $record->export();
                        
                        return response()->streamDownload(function () use ($exportData) {
                            echo $exportData;
                        }, $record->slug . '.json');
                    }),
                
                Tables\Actions\DeleteAction::make()
                    ->label('حذف')
                    ->color('danger')
                    ->size('sm')
                    ->visible(fn (Theme $record): bool => !$record->is_default)
                    ->requiresConfirmation()
                    ->modalHeading('حذف الثيم')
                    ->modalDescription('هل أنت متأكد من حذف هذا الثيم؟ لا يمكن التراجع عن هذا الإجراء.')
                    ->modalSubmitActionLabel('حذف')
                    ->modalCancelActionLabel('إلغاء'),
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
                        ->modalSubmitActionLabel('تفعيل')
                        ->modalCancelActionLabel('إلغاء')
                        ->action(function ($records) {
                            $selected = $records->first();
                            
                            if ($selected) {
                                // Deactivate all themes first
                                Theme::where('id', '!=', $selected->id)->update(['is_active' => false]);
                                
                                // Activate selected theme
                                $selected->update(['is_active' => true]);
                                
                                // Apply theme
                                $this->applyTheme($selected);
                                
                                static::notify('success', 'تم تفعيل الثيمات بنجاح');
                            }
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
                    
                    Tables\Actions\BulkAction::make('delete_bulk')
                        ->label('حذف المحدد')
                        ->icon('heroicon-m-trash')
                        ->color('danger')
                        ->visible(fn ($records): bool => $records->where('is_default', true)->isEmpty())
                        ->requiresConfirmation()
                        ->modalHeading('حذف الثيمات')
                        ->modalDescription('هل أنت متأكد من حذف هذه الثيمات؟ لا يمكن التراجع عن هذا الإجراء.')
                        ->modalSubmitActionLabel('حذف')
                        ->modalCancelActionLabel('إلغاء'),
                ]),
            ])
            ->defaultSort('is_default', 'desc')
            ->poll('30s');
    }

    /**
     * Apply theme to application
     */
    private function applyTheme(Theme $theme): void
    {
        // Clear application cache
        cache()->forget('current_theme');
        cache()->forget('theme_settings');
        cache()->forget('custom_css');
        cache()->forget('custom_js');
        
        // Update settings
        $settings = app('settings');
        if ($settings) {
            $settings->update([
                'current_theme' => $theme->slug,
                'theme_settings' => json_encode($theme->settings),
                'theme_colors' => $theme->color_scheme,
                'layout_type' => $theme->layout_type
            ]);
        }
        
        // Generate theme files
        $theme->generateThemeFile();
    }
}