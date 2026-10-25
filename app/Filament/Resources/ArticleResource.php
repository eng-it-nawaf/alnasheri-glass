<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'المقالات';

    protected static ?string $modelLabel = 'مقال';

    protected static ?string $pluralModelLabel = 'المقالات';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // القسم الأيسر: محتوى المقال الأساسي (2/3 المساحة)
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('تفاصيل المقال الرئيسي')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('عنوان المقال')
                                    ->placeholder('أدخل عنوان المقال هنا...')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(
                                        fn (Forms\Set $set, ?string $state) =>
                                            $set('slug', Str::slug($state ?? '', '-', 'ar'))
                                    ),

                                Forms\Components\TextInput::make('slug')
                                    ->label('رابط المقال (Slug)')
                                    ->placeholder('يتم توليده تلقائياً من العنوان')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->helperText('يستخدم في رابط الصفحة، يُفضل ترك الحروف باللغة العربية أو الإنجليزية دون رموز خاصة.'),

                                Forms\Components\RichEditor::make('content')
                                    ->label('محتوى المقال')
                                    ->required()
                                    ->placeholder('اكتب محتوى المقال هنا...')
                                    ->columnSpanFull(),
                            ]),

                        Forms\Components\Section::make('تحسين محركات البحث (SEO)')
                            ->description('ساعد محركات البحث على فهم مقالك للوصول لجمهور أوسع')
                            ->collapsible()
                            ->schema([
                                Forms\Components\Textarea::make('meta_description')
                                    ->label('وصف المقال في جوجل (Meta Description)')
                                    ->placeholder('أدخل وصفاً مقنعاً ومختصراً يظهر في نتائج البحث...')
                                    ->rows(3)
                                    ->maxLength(160) // الحد المثالي لمحركات البحث
                                    ->live(onBlur: true)
                                    ->helperText('يُفضل ألا يتجاوز الوصف 160 حرفاً ليظهر كاملاً في صفحة نتائج بحث جوجل.'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                // القسم الأيمن: الصورة والإعدادات الجانبية (1/3 المساحة)
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('الصورة البارزة')
                            ->schema([
                                Forms\Components\FileUpload::make('image_path')
                                    ->label('صورة الغلاف')
                                    ->image()
                                    ->imageEditor()
                                    ->disk('public')
                                    ->directory('articles')
                                    ->maxSize(5120)
                                    ->helperText('أقصى حجم: 5 ميجابايت (يُفضل استخدام أبعاد 1200×630px)'),
                            ]),

                        Forms\Components\Section::make('إحصائيات ونشر')
                            ->schema([
                                Forms\Components\Placeholder::make('created_at')
                                    ->label('تاريخ الإنشاء')
                                    ->content(fn (?Article $record): string => $record ? $record->created_at->format('Y-m-d H:i') : '-'),

                                Forms\Components\Placeholder::make('views_count')
                                    ->label('عدد المشاهدات')
                                    ->content(fn (?Article $record): string => $record ? number_format($record->views_count) . ' مشاهدة' : '0'),
                            ])
                            ->hidden(fn (?Article $record) => $record === null), // يظهر فقط عند التعديل
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('الصورة')
                    ->square()
                    ->disk('public')
                    ->defaultImageUrl(url('/images/placeholder.png')), // صورة افتراضية في حال عدم وجود صورة

                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان المقال')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->weight('bold')
                    ->description(fn (Article $record): string => Str::limit($record->slug, 40)), // عرض الرابط تحت العنوان بشكل مصغر

                Tables\Columns\TextColumn::make('views_count')
                    ->label('المشاهدات')
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->numeric(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ النشر')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                // يمكن إضافة فلاتر مخصصة هنا مستقبلاً
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}