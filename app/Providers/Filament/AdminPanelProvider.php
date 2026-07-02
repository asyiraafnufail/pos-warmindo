<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
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
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\Facades\Blade;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->darkMode(false)
            // Menggunakan warna modern zinc dan amber sebagai aksen warmindo
            ->colors([
                'primary' => Color::Zinc,
                'success' => Color::Emerald,
                'warning' => Color::Amber,
                'danger' => Color::Rose,
                'info' => Color::Indigo,
            ])
            // Mengubah font global ke Plus Jakarta Sans yang minimalis
            ->font('Plus Jakarta Sans')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Kita akan ganti widget bawaan dengan widget buatan sendiri nanti
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
            // RENDER HOOK: Menyuntikkan CSS Kustom Tanpa Perlu Compile NPM/Vite
            ->renderHook(
                'panels::styles.after',
                fn () => Blade::render('
                    <style>
                        /* Skema Warna Terang Bersih untuk Sidebar & Header */
                        .fi-sidebar {
                            background-color: #ffffff !important; /* Putih Bersih */
                            border-right: 1px solid #e2e8f0 !important;
                        }
                        .fi-sidebar-nav-label {
                            color: #64748b !important; /* Gray-500 */
                        }
                        .fi-sidebar-nav-link-label {
                            color: #334155 !important; /* Slate-700 */
                        }
                        .fi-sidebar-nav-link:hover {
                            background-color: #f1f5f9 !important; /* Soft Slate */
                        }
                        .fi-sidebar-nav-link-active {
                            background-color: #ff9800 !important; /* Warna aksen aktif Warmindo */
                            border-radius: 8px !important;
                        }
                        .fi-sidebar-nav-link-active .fi-sidebar-nav-link-label {
                            color: #ffffff !important; /* Putih kontras tinggi */
                            font-weight: 700 !important;
                        }
                        .fi-sidebar-nav-link-active svg {
                            color: #ffffff !important;
                        }
                        .fi-topbar {
                            background-color: #ffffff !important; /* Putih */
                            border-bottom: 1px solid #e2e8f0 !important;
                        }
                        .fi-topbar-user-menu button span {
                            color: #1e293b !important; /* Teks User Menu Gelap */
                        }
                        
                        /* Pengaturan Sudut Tumpul Halus (Sedikit Rounded Corner) */
                        .fi-card, .fi-ta-ctn, .fi-modal-window, input, select, textarea, button {
                            border-radius: 8px !important; /* 8px-12px konsisten di semua box */
                            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05), 0 2px 4px -2px rgb(0 0 0 / 0.05) !important;
                        }
                        
                        /* Background Utama Konten Kerja (Sisi Terang Bersih) */
                        body {
                            background-color: #f8fafc !important;
                        }
                    </style>
                ')
            );
    }
}