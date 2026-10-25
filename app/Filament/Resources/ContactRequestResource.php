<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactRequestResource\Pages;
use App\Models\ContactRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactRequestResource extends Resource
{
    protected static ?string $model = ContactRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationLabel = 'طلبات العملاء';

    protected static ?string $modelLabel = 'طلب عميل';

    protected static ?string $pluralModelLabel = 'طلبات العملاء';

    protected static ?int $navigationSort = 4;

    // عرض عدد الطلبات المعلقة (pending) كشارة تنبيه بجانب اسم القائمة
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('بيانات العميل التواصلية')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('اسم العميل')
                                    ->disabled(),

                                Forms\Components\TextInput::make('phone')
                                    ->label('رقم الهاتف')
                                    ->suffixAction(
                                        Forms\Components\Actions\Action::make('call')
                                            ->icon('heroicon-o-phone')
                                            ->color('success')
                                            ->url(fn (?string $state) => $state ? "tel:{$state}" : null)
                                            ->openUrlInNewTab()
                                    )
                                    ->disabled(),

                                Forms\Components\TextInput::make('email')
                                    ->label('البريد الإلكتروني')
                                    ->suffixAction(
                                        Forms\Components\Actions\Action::make('mail')
                                            ->icon('heroicon-o-envelope')
                                            ->color('info')
                                            ->url(fn (?string $state) => $state ? "mailto:{$state}" : null)
                                            ->openUrlInNewTab()
                                    )
                                    ->disabled(),

                                Forms\Components\TextInput::make('service_type')
                                    ->label('الخدمة المطلوبة')
                                    ->disabled(),
                            ])->columns(2),

                        Forms\Components\Section::make('تفاصيل الرسالة والطلب')
                            ->icon('heroicon-o-chat-bubble-bottom-center-text')
                            ->schema([
                                Forms\Components\Textarea::make('message_body')
                                    ->label('نص الرسالة')
                                    ->rows(6)
                                    ->disabled()
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('إدارة حالة الطلب')
                            ->icon('heroicon-o-cog')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->label('حالة الطلب')
                                    ->options(ContactRequest::STATUSES)
                                    ->required()
                                    ->native(false),

                                Forms\Components\Placeholder::make('created_at')
                                    ->label('تاريخ إرسال الطلب')
                                    ->content(fn (?ContactRequest $record): string => $record ? $record->created_at->format('Y-m-d (h:i A)') : '-'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('العميل')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('phone')
                    ->label('الهاتف')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-o-phone')
                    ->iconPosition('before'),

                Tables\Columns\TextColumn::make('service_type')
                    ->label('الخدمة')
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->formatStateUsing(
                        fn (string $state): string =>
                            ContactRequest::STATUSES[$state] ?? $state
                    )
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'processed' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الطلب')
                    ->dateTime('d M Y - h:i A')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('تصفية حسب الحالة')
                    ->options(ContactRequest::STATUSES),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),

                Tables\Actions\Action::make('process')
                    ->label('تمت المعالجة')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->button()
                    ->size('xs')
                    ->requiresConfirmation()
                    ->visible(
                        fn (ContactRequest $record): bool =>
                            $record->status === 'pending'
                    )
                    ->action(
                        fn (ContactRequest $record) =>
                            $record->update([
                                'status' => 'processed',
                            ])
                    ),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactRequests::route('/'),
            'view' => Pages\ViewContactRequest::route('/{record}'),
        ];
    }
}