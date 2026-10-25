<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'معرض الأعمال';

    protected static ?string $modelLabel = 'عمل';

    protected static ?string $pluralModelLabel = 'معرض الأعمال';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('معلومات العمل الأساسية')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('اسم المشروع')
                                    ->placeholder('أدخل اسم المشروع أو العمل...')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\Select::make('category')
                                    ->label('قسم المشروع')
                                    ->options(Project::CATEGORIES)
                                    ->default('other')
                                    ->required()
                                    ->native(false),

                                Forms\Components\Textarea::make('description')
                                    ->label('وصف العمل')
                                    ->placeholder('أدخل تفاصيل ومواصفات هذا العمل...')
                                    ->rows(4)
                                    ->columnSpanFull(),
                            ])->columns(2),

                        Forms\Components\Section::make('معرض الصور والوسائط')
                            ->schema([
                                Forms\Components\FileUpload::make('image_path')
                                    ->label('الصورة الرئيسية للمشروع')
                                    ->image()
                                    ->disk('public')
                                    ->directory('projects')
                                    ->visibility('public')
                                    ->imageEditor()
                                    ->imagePreviewHeight('180')
                                    ->maxSize(5120)
                                    ->required()
                                    ->columnSpanFull(),

                                Forms\Components\FileUpload::make('gallery')
                                    ->label('معرض صور إضافية للمشروع')
                                    ->image()
                                    ->multiple()
                                    ->reorderable()
                                    ->appendFiles()
                                    ->disk('public')
                                    ->directory('projects/gallery')
                                    ->visibility('public')
                                    ->imageEditor()
                                    ->imagePreviewHeight('150')
                                    ->maxSize(5120)
                                    ->helperText('يمكنك رفع عدة صور، وسحبها لتغيير ترتيب عرضها داخل المعرض.')
                                    ->columnSpanFull(),
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
                    ->label('الصورة الرئيسية')
                    ->disk('public')
                    ->square(),

                Tables\Columns\TextColumn::make('title')
                    ->label('اسم المشروع')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('category')
                    ->label('القسم')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(
                        fn (?string $state): string =>
                            Project::CATEGORIES[$state] ?? 'أخرى'
                    )
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('تصفية حسب القسم')
                    ->options(Project::CATEGORIES),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}