<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'الفواتير';

    protected static ?string $modelLabel = 'فاتورة';

    protected static ?string $pluralModelLabel = 'الفواتير';

    protected static ?string $navigationGroup = 'الإدارة المالية';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('تفاصيل الفاتورة')
                    ->schema([
                        Forms\Components\TextInput::make('invoice_number')
                            ->label('رقم الفاتورة')
                            ->default('INV-' . time())
                            ->required(),
                        Forms\Components\Select::make('patient_id')
                            ->label('المريض')
                            ->relationship('patient', 'name')
                            ->required()
                            ->searchable(),
                        Forms\Components\Select::make('appointment_id')
                            ->label('الموعد المرتبط')
                            ->relationship('appointment', 'appointment_date')
                            ->searchable(),
                        Forms\Components\DatePicker::make('invoice_date')
                            ->label('تاريخ الفاتورة')
                            ->default(now())
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->label('الحالة')
                            ->options([
                                'unpaid' => 'غير مدفوع',
                                'paid' => 'مدفوع',
                                'partial' => 'مدفوع جزئياً',
                                'cancelled' => 'ملغي',
                            ])
                            ->default('unpaid'),
                    ])->columns(2),

                Forms\Components\Section::make('المبالغ')
                    ->schema([
                        Forms\Components\TextInput::make('amount')
                            ->label('المبلغ الإجمالي')
                            ->numeric()
                            ->prefix('ر.س')
                            ->required(),
                        Forms\Components\TextInput::make('paid_amount')
                            ->label('المبلغ المدفوع')
                            ->numeric()
                            ->prefix('ر.س')
                            ->default(0),
                    ])->columns(2),

                Forms\Components\Repeater::make('items')
                    ->label('الخدمات / البنود')
                    ->schema([
                        Forms\Components\TextInput::make('description')->label('الوصف')->required(),
                        Forms\Components\TextInput::make('price')->label('السعر')->numeric()->required(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->label('رقم الفاتورة')
                    ->searchable(),
                Tables\Columns\TextColumn::make('patient.name')
                    ->label('المريض')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('المبلغ')
                    ->money('SAR'),
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'unpaid' => 'danger',
                        'partial' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('invoice_date')
                    ->label('التاريخ')
                    ->date(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'paid' => 'مدفوع',
                        'unpaid' => 'غير مدفوع',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}
