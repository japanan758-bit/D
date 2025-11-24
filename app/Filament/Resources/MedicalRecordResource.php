<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedicalRecordResource\Pages;
use App\Models\MedicalRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MedicalRecordResource extends Resource
{
    protected static ?string $model = MedicalRecord::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'السجلات الطبية';

    protected static ?string $modelLabel = 'سجل طبي';

    protected static ?string $pluralModelLabel = 'السجلات الطبية';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('معلومات المريض')
                    ->schema([
                        Forms\Components\TextInput::make('patient_name')
                            ->label('اسم المريض')
                            ->required(),
                        Forms\Components\TextInput::make('patient_email')
                            ->label('البريد الإلكتروني')
                            ->email()
                            ->required(),
                        Forms\Components\TextInput::make('patient_phone')
                            ->label('رقم الهاتف')
                            ->required(),
                        Forms\Components\DatePicker::make('patient_date_of_birth')
                            ->label('تاريخ الميلاد'),
                        Forms\Components\Select::make('patient_gender')
                            ->label('الجنس')
                            ->options([
                                'male' => 'ذكر',
                                'female' => 'أنثى',
                            ]),
                    ])->columns(2),

                Forms\Components\Section::make('التفاصيل الطبية')
                    ->schema([
                        Forms\Components\Select::make('doctor_id')
                            ->label('الطبيب المعالج')
                            ->relationship('doctor', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\Textarea::make('diagnosis')
                            ->label('التشخيص')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('treatment_plan')
                            ->label('خطة العلاج')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('notes')
                            ->label('ملاحظات إضافية')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('العلامات الحيوية')
                    ->schema([
                        Forms\Components\KeyValue::make('vital_signs')
                            ->label('العلامات الحيوية')
                            ->keyLabel('المؤشر')
                            ->valueLabel('القيمة')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('المرفقات')
                    ->schema([
                        Forms\Components\FileUpload::make('attachments')
                            ->label('الملفات المرفقة')
                            ->multiple()
                            ->disk('public')
                            ->directory('medical-records')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('patient_name')
                    ->label('المريض')
                    ->searchable(),
                Tables\Columns\TextColumn::make('doctor.name')
                    ->label('الطبيب')
                    ->sortable(),
                Tables\Columns\TextColumn::make('diagnosis')
                    ->label('التشخيص')
                    ->limit(30)
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('print_prescription')
                    ->label('طباعة الوصفة')
                    ->icon('heroicon-o-printer')
                    ->url(fn (MedicalRecord $record) => route('medical-records.prescription', $record))
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
            'index' => Pages\ListMedicalRecords::route('/'),
            'create' => Pages\CreateMedicalRecord::route('/create'),
            'edit' => Pages\EditMedicalRecord::route('/{record}/edit'),
        ];
    }
}
