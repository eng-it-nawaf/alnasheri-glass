<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaqResource\Pages;
use App\Models\Faq;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationLabel = 'الأسئلة الشائعة';

    protected static ?string $modelLabel = 'سؤال شائع';

    protected static ?string $pluralModelLabel = 'الأسئلة الشائعة';

    protected static ?string $navigationGroup = 'محتوى الموقع';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('السؤال والإجابة')
                            ->schema([
                                Forms\Components\TextInput::make('question')
                                    ->label('السؤال')
                                    ->placeholder('مثال: ما هي أوقات العمل الرسمية؟')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\Textarea::make('answer')
                                    ->label('الإجابة التفصيلية')
                                    ->placeholder('أدخل الإجابة الواضحة للعميل هنا...')
                                    ->required()
                                    ->rows(5)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('التصنيف والحالة')
                            ->schema([
                                Forms\Components\TextInput::make('category')
                                    ->label('القسم / التصنيف')
                                    ->placeholder('مثال: الزجاج السيكوريت')
                                    ->helperText('يُستخدم لتجميع الأسئلة المتشابهة في العرض.'),

                                Forms\Components\TextInput::make('sort_order')
                                    ->label('ترتيب الظهور')
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(0)
                                    ->helperText('الرقم الأصغر يظهر أولاً.'),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('نشر السؤال')
                                    ->helperText('إظهار السؤال للمستخدِمين في الموقع.')
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
            ->reorderable('sort_order') // تفعيل إعادة الترتيب بأسلوب السحب والإفلات
            ->columns([
                Tables\Columns\TextColumn::make('question')
                    ->label('السؤال')
                    ->searchable()
                    ->wrap()
                    ->weight('bold')
                    ->limit(60),

                Tables\Columns\TextColumn::make('category')
                    ->label('القسم')
                    ->badge()
                    ->color('gray')
                    ->searchable()
                    ->sortable(),

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

                Tables\Filters\SelectFilter::make('category')
                    ->label('القسم'),
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
            'index' => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'edit' => Pages\EditFaq::route('/{record}/edit'),
        ];
    }
}