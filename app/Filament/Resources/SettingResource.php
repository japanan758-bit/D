<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'إعدادات النظام';

    protected static ?string $modelLabel = 'إعداد';

    protected static ?string $pluralModelLabel = 'إعدادات النظام';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('معلومات العيادة')
                    ->schema([
                        Forms\Components\TextInput::make('clinic_name')
                            ->label('اسم العيادة')
                            ->required(),
                        Forms\Components\TextInput::make('clinic_phone')
                            ->label('رقم الهاتف')
                            ->required(),
                        Forms\Components\TextInput::make('clinic_email')
                            ->label('البريد الإلكتروني')
                            ->email()
                            ->required(),
                        Forms\Components\Textarea::make('clinic_address')
                            ->label('العنوان')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('روابط التواصل الاجتماعي')
                    ->schema([
                        Forms\Components\TextInput::make('whatsapp_number')
                            ->label('رقم الواتساب'),
                        Forms\Components\TextInput::make('facebook_url')
                            ->label('فيسبوك')
                            ->url(),
                        Forms\Components\TextInput::make('twitter_url')
                            ->label('تويتر / X')
                            ->url(),
                        Forms\Components\TextInput::make('instagram_url')
                            ->label('انستجرام')
                            ->url(),
                    ])->columns(2),

                Forms\Components\Section::make('إعدادات المواعيد والمميزات')
                    ->schema([
                        Forms\Components\Toggle::make('enable_booking')
                            ->label('تفعيل الحجز الإلكتروني')
                            ->default(true),
                        Forms\Components\Toggle::make('enable_payment')
                            ->label('تفعيل الدفع الإلكتروني')
                            ->default(false),
                        Forms\Components\Toggle::make('enable_registration')
                            ->label('تفعيل تسجيل المرضى')
                            ->default(true),
                        Forms\Components\TextInput::make('appointment_duration')
                            ->label('مدة الموعد (بالدقائق)')
                            ->numeric()
                            ->default(30)
                            ->required(),
                        Forms\Components\TextInput::make('max_appointments_per_day')
                            ->label('الحد الأقصى للمواعيد يومياً')
                            ->numeric()
                            ->default(20)
                            ->required(),
                        Forms\Components\KeyValue::make('working_hours')
                            ->label('ساعات العمل')
                            ->keyLabel('اليوم')
                            ->valueLabel('الساعات')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('clinic_name')
                    ->label('اسم العيادة'),
                Tables\Columns\TextColumn::make('clinic_phone')
                    ->label('الهاتف'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('آخر تحديث')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // No bulk actions needed for singleton-like settings
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
