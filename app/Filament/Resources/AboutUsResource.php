<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutUsResource\Pages;
use App\Models\AboutUs;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AboutUsResource extends Resource
{
    protected static ?string $model = AboutUs::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationLabel = 'من نحن';

    protected static ?string $modelLabel = 'محتوى من نحن';

    protected static ?string $pluralModelLabel = 'من نحن';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('AboutUsTabs')
                    ->tabs([
                        // التبويب الأول: المعلومات الأساسية والإعلام
                        Forms\Components\Tabs\Tab::make('المعلومات الأساسية')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\Section::make('العناوين التفصيلية')
                                    ->description('أدخل العناوين الرئيسية للصفحة وسنوات الخبرة')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('العنوان الرئيسي')
                                            ->placeholder('مثال: نبذة عن شركتنا')
                                            ->required()
                                            ->maxLength(255),

                                        Forms\Components\TextInput::make('subtitle')
                                            ->label('العنوان الفرعي')
                                            ->placeholder('مثال: ريادة في التكنولوجيا والابتكار')
                                            ->maxLength(255),

                                        Forms\Components\TextInput::make('experience_years')
                                            ->label('سنوات الخبرة')
                                            ->numeric()
                                            ->minValue(0)
                                            ->default(0)
                                            ->suffix('سنوات'),
                                    ])->columns(2),

                                Forms\Components\Section::make('الوسائط والصور')
                                    ->schema([
                                        Forms\Components\FileUpload::make('image_path')
                                            ->label('صورة من نحن')
                                            ->image()
                                            ->imageEditor() // تفعيل محرر الصور لتكبير/قص الصورة بسهولة
                                            ->disk('public')
                                            ->directory('about')
                                            ->maxSize(2048)
                                            ->helperText('الحد الأقصى لحجم الملف: 2 ميجابايت (يُفضل استخدام أبعاد متناسبة)'),
                                    ]),
                            ]),

                        // التبويب الثاني: الوصف والتفاصيل
                        Forms\Components\Tabs\Tab::make('تفاصيل المحتوى')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Forms\Components\Section::make('الوصف الرئيسي')
                                    ->schema([
                                        Forms\Components\RichEditor::make('main_description')
                                            ->label('الوصف الرئيسي')
                                            ->placeholder('أكتب النص الكامل للصفحة هنا...')
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
                                    ]),
                            ]),

                        // التبويب الثالث: الرؤية والرسالة
                        Forms\Components\Tabs\Tab::make('الرؤية والرسالة')
                            ->icon('heroicon-o-flag')
                            ->schema([
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\Textarea::make('vision')
                                            ->label('رؤيتنا')
                                            ->placeholder('أدخل رؤية المؤسسة المستقبليّة...')
                                            ->rows(5)
                                            ->maxLength(1000),

                                        Forms\Components\Textarea::make('mission')
                                            ->label('رسالتنا')
                                            ->placeholder('أدخل رسالة المؤسسة وأهدافها الحالية...')
                                            ->rows(5)
                                            ->maxLength(1000),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('الصورة')
                    ->circular()
                    ->disk('public'),

                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('experience_years')
                    ->label('سنوات الخبرة')
                    ->sortable()
                    ->badge()
                    ->color('success')
                    ->suffix(' سنة'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('آخر تحديث')
                    ->dateTime('d M Y - h:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListAboutUs::route('/'),
            'create' => Pages\CreateAboutUs::route('/create'),
            'edit' => Pages\EditAboutUs::route('/{record}/edit'),
        ];
    }
}