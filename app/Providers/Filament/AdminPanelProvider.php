<?php

namespace App\Providers\Filament;

use App\Filament\Resources\UserResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Rmsramos\Activitylog\ActivitylogPlugin;
use Njxqlus\FilamentProgressbar\FilamentProgressbarPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->profile()
            ->databaseNotifications()
            ->breadcrumbs(false)
            ->maxContentWidth('full')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->colors([
                'primary' => Color::Teal,
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Blue,
                'success' => Color::Lime,
                'warning' => Color::Orange,
            ])
            ->font('Merryweather')
            ->darkMode(false)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')

            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                //    Widgets\AccountWidget::class,
                //    Widgets\FilamentInfoWidget::class,
                //    Widgets\StatsOverviewWidget::class,

            ])
            ->userMenuItems([
                'logout' => MenuItem::make()->label('Log out'),
                // ...
            ])
            ->navigationGroups([
                'Admin Management',
                'General Management',
                'All Documents',
                'Incoming Documents',
                'Documents In-Process',
                'Outgoing Documents',
                'Activity Log'
            ])
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
            ])
            ->plugin(new \RickDBCN\FilamentEmail\FilamentEmail())
            ->plugin(FilamentProgressbarPlugin::make()->color('#29b000'))
        ->plugins([
                ActivitylogPlugin::make()
                    ->navigationGroup('Activities Log')
                    ->navigationCountBadge(true),
            ]);
    }
}
