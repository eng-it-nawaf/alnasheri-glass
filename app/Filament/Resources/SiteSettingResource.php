<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'إعدادات الموقع';

    protected static ?string $modelLabel = 'إعداد';

    protected static ?string $pluralModelLabel = 'إعدادات الموقع';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Select::make('key')
                ->label('نوع الإعداد')
                ->options([
                    'site_name' => 'اسم الموقع',
                    'phone' => 'رقم الهاتف',
                    'whatsapp' => 'رقم الواتساب',
                    'email' => 'البريد الإلكتروني',
                    'google_map' => 'رابط الخريطة',
                    'facebook' => 'فيسبوك',
                    'instagram' => 'إنستغرام',
                    'logo' => 'شعار الموقع',
                    'address' => 'عنوان المحل',
                ])
                ->required()
                ->unique(ignoreRecord: true)
                ->live()
                ->disabledOn('edit'),

Forms\Components\FileUpload::make('logo_upload')
    ->label('شعار الموقع')
    ->image()
    ->disk('public')
    ->directory('settings')
    ->visibility('public')
    ->maxSize(2048)
    ->imagePreviewHeight('150')
    ->openable()
    ->downloadable()
    ->visible(
        fn (Forms\Get $get): bool =>
            $get('key') === 'logo'
    )
    ->dehydrated(
        fn (Forms\Get $get): bool =>
            $get('key') === 'logo'
    )
    ->formatStateUsing(function (
        ?SiteSetting $record
    ): array {
        if (
            $record?->key === 'logo'
            && filled($record->value)
        ) {
            return [$record->value];
        }

        return [];
    }),

            Forms\Components\TextInput::make('value')
                ->label('قيمة الإعداد')
                ->maxLength(2000)
                ->required(
                    fn (Forms\Get $get): bool =>
                        $get('key') !== 'logo'
                )
                ->visible(
                    fn (Forms\Get $get): bool =>
                        $get('key') !== 'logo'
                )
                ->dehydrated(
                    fn (Forms\Get $get): bool =>
                        $get('key') !== 'logo'
                ),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('نوع الإعداد')
                    ->searchable(),

                Tables\Columns\TextColumn::make('value')
                    ->label('القيمة')
                    ->limit(60),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
}