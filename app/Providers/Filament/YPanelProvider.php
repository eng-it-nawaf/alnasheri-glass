<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class YPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')

            // 1. هوية وتصميم اللوحة
            ->brandName('زجاج سيكوريت - جدة')
            ->brandLogo(asset('images/logo.png')) // مسار الشعار الخاص بموقعك
            ->brandLogoHeight('2.5rem')
            ->favicon(asset('favicon.ico'))

            // 2. تخصيص الألوان والخطوط والتنقل السريع
            ->colors([
                'primary' => Color::Amber,
                'gray' => Color::Zinc,
            ])
            ->font('Cairo')
            ->spa() // تفعيل وضع التنقل السريع دون إعادة تحميل الصفحة

            // 3. تحسينات تجربة المستخدم والتنقل (UI/UX)
            ->sidebarCollapsibleOnDesktop() // إكانية طي القائمة الجانبية لتوفير مساحة للعمل
            ->maxContentWidth('full')       // استغلال كامل عرض الشاشة
            ->databaseNotifications()       // تفعيل نظام الإشعارات الداخلية
            ->globalSearchKeyBindings(['command+k', 'ctrl+k']) // اختصار البحث السريع

            // 4. تنظيم القائمة الجانبية في مجموعات
            ->navigationGroups([
                'الطلبات والتواصل',
                'المحتوى والخدمات',
                'إدارة النظام',
            ])

            // 5. إعدادات الحساب وتحديث الملف الشخصي
            ->login()
            ->profile()

            // 6. اكتشاف الموارد والصفحات
            ->discoverResources(
                in: app_path('Filament/Resources'),
                for: 'App\\Filament\\Resources'
            )
            ->discoverPages(
                in: app_path('Filament/Pages'),
                for: 'App\\Filament\\Pages'
            )
            ->pages([
                Pages\Dashboard::class,
            ])

            // 7. اكتشاف الويدجت (Widgets)
            ->discoverWidgets(
                in: app_path('Filament/Widgets'),
                for: 'App\\Filament\\Widgets'
            )
            ->widgets([
                Widgets\AccountWidget::class,
                // تم إزالة FilamentInfoWidget للحصول على واجهة نظيفة ومخصصة
            ])

            // 8. البرمجيات الوسيطة (Middleware)
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}