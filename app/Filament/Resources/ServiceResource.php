<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationLabel = 'الخدمات';

    protected static ?string $modelLabel = 'خدمة';

    protected static ?string $pluralModelLabel = 'الخدمات';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // العمود الرئيسي: المحتوى التفصيلي للخدمة (2/3 المساحة)
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('معلومات الخدمة الرئيسية')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('اسم الخدمة')
                                    ->placeholder('مثال: تركيب زجاج سيكوريت للمحلات')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(
                                        fn (Forms\Set $set, ?string $state) =>
                                            $set('slug', Str::slug($state ?? '', '-', 'ar'))
                                    ),

                                Forms\Components\TextInput::make('slug')
                                    ->label('الرابط المختصر (Slug)')
                                    ->placeholder('يتم توليده تلقائياً من اسم الخدمة')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->helperText('يُستخدم في رابط الصفحة في الموقع (URL).'),

                                Forms\Components\RichEditor::make('description')
                                    ->label('وصف الخدمة التفصيلي')
                                    ->placeholder('اكتب تفاصيل الخدمة والمميزات التي تقدمها هنا...')
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'bulletList',
                                        'orderedList',
                                        'link',
                                        'undo',
                                        'redo',
                                    ])
                                    ->columnSpanFull(),
                            ])->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),

                // العمود الجانبي: المظهر والإعدادات الفرعية (1/3 المساحة)
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('أيقونة الخدمة')
                            ->schema([
                                Forms\Components\TextInput::make('icon_class')
                                    ->label('كود الأيقونة (FontAwesome)')
                                    ->default('fa-solid fa-layer-group')
                                    ->placeholder('fa-solid fa-door-open')
                                    ->helperText('أدخل كلاس الأيقونة من FontAwesome. مثال: fa-solid fa-screwdriver-wrench'),
                            ]),

                        Forms\Components\Section::make('معلومات النظام')
                            ->schema([
                                Forms\Components\Placeholder::make('created_at')
                                    ->label('تاريخ الإضافة')
                                    ->content(fn (?Service $record): string => $record ? $record->created_at->format('Y-m-d H:i') : '-'),

                                Forms\Components\Placeholder::make('updated_at')
                                    ->label('آخر تحديث')
                                    ->content(fn (?Service $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                            ])
                            ->hidden(fn (?Service $record) => $record === null),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('icon_class')
                    ->label('الأيقونة')
                    ->badge()
                    ->color('gray')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('title')
                    ->label('اسم الخدمة')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Service $record): string => Str::limit($record->slug, 40)),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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