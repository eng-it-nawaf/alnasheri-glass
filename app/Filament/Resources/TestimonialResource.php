<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationLabel = 'آراء العملاء';

    protected static ?string $modelLabel = 'رأي عميل';

    protected static ?string $pluralModelLabel = 'آراء العملاء';

    protected static ?string $navigationGroup = 'محتوى الموقع';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // العمود الرئيسي: بيانات العميل والتقييم (2/3 المساحة)
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('معلومات العميل والرأي')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('اسم العميل')
                                    ->placeholder('مثال: أسامة عبدالله')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('position')
                                    ->label('الصفة / المدينة')
                                    ->placeholder('مثال: مدير شركة / الرياض')
                                    ->maxLength(255),

                                Forms\Components\Select::make('rating')
                                    ->label('التقييم (النجوم)')
                                    ->options([
                                        5 => '⭐⭐⭐⭐⭐ (5/5) ممتاز',
                                        4 => '⭐⭐⭐⭐ (4/5) جيد جداً',
                                        3 => '⭐⭐⭐ (3/5) متوسط',
                                        2 => '⭐⭐ (2/5) مقبول',
                                        1 => '⭐ (1/5) ضعيف',
                                    ])
                                    ->default(5)
                                    ->required()
                                    ->native(false)
                                    ->columnSpanFull(),

                                Forms\Components\Textarea::make('content')
                                    ->label('نص التقييم / الرأي')
                                    ->placeholder('أدخل ما قاله العميل عن خدماتكم بكل أمانة...')
                                    ->required()
                                    ->rows(5)
                                    ->columnSpanFull(),
                            ])->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),

                // العمود الجانبي: الصورة والحالة (1/3 المساحة)
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('صورة العميل')
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label('الصورة الشخصية')
                                    ->image()
                                    ->avatar() // عرض الصورة كرمز تعبيري دائرية أثناء الرفع
                                    ->disk('public')
                                    ->directory('testimonials')
                                    ->imageEditor()
                                    ->maxSize(2048)
                                    ->helperText('اختياري: يفضل استخدام صورة مربعة بحجم أقل من 2 ميجابايت'),
                            ]),

                        Forms\Components\Section::make('إعدادات النشر')
                            ->schema([
                                Forms\Components\TextInput::make('sort_order')
                                    ->label('ترتيب الظهور')
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(0)
                                    ->helperText('الرقم الأصغر يظهر أولاً في الموقع.'),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('نشر الرأي')
                                    ->helperText('تفعيل إظهار هذا الرأي في الموقع')
                                    ->default(true)
                                    ->onColor('success')
                                    ->offColor('danger'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order') // إمكانية سحب وإفلات الصفوف لترتيبها مباشرة
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('الصورة')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(url('/images/default-avatar.png')),

                Tables\Columns\TextColumn::make('name')
                    ->label('العميل')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Testimonial $record): string => $record->position ?? '-'),

                Tables\Columns\TextColumn::make('rating')
                    ->label('التقييم')
                    ->formatStateUsing(fn (int $state): string => str_repeat('⭐', $state))
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('حالة النشر')
                    ->sortable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('الترتيب')
                    ->sortable()
                    ->alignCenter(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('حالة النشر')
                    ->trueLabel('المنشورة فقط')
                    ->falseLabel('المخفية فقط'),

                Tables\Filters\SelectFilter::make('rating')
                    ->label('تصفية حسب التقييم')
                    ->options([
                        5 => '5 نجوم',
                        4 => '4 نجوم',
                        3 => '3 نجوم',
                        2 => 'نجمتان',
                        1 => 'نجمة واحدة',
                    ]),
            ])
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
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}