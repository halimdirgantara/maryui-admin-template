<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Role\RoleList;
use App\Livewire\Admin\User\UserList;
use App\Livewire\Admin\Permission\PermissionList;
use App\Livewire\Admin\Settings\SettingsIndex;
use App\Livewire\Admin\Settings\GeneralSettings;
use App\Livewire\Admin\Settings\SecuritySettings;
use App\Livewire\Admin\Settings\NotificationSettings;
use App\Livewire\Admin\Settings\SystemSettings;


Route::get('/login', Login::class)->name('login');

Route::middleware(['auth'])->group(function () {

    Route::get('/logout', function () {
        auth()->logout();
        return redirect()->route('login');
    })->name('logout');

    // Dashboard routes
    Route::middleware(['can:dashboard.view'])->group(function () {
        Route::get('/', Dashboard::class)->name('welcome');
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
    });

    // User Management routes
    Route::prefix('user-management')->middleware(['can:user-management.view'])->group(function () {
        Route::get('/user', UserList::class)
            ->middleware('can:user-management.user.view')
            ->name('user-management.user');
            
        Route::get('/role', RoleList::class)
            ->middleware('can:user-management.role.view')
            ->name('user-management.role');
            
        Route::get('/permission', PermissionList::class)
            ->middleware('can:user-management.permission.view')
            ->name('user-management.permission');
    });

    // Settings routes
    Route::prefix('settings')->middleware(['can:settings.view'])->group(function () {
        Route::get('/', SettingsIndex::class)->name('settings.index');
        
        Route::get('/general', GeneralSettings::class)
            ->middleware('can:settings.general.view')
            ->name('settings.general');
            
        Route::get('/security', SecuritySettings::class)
            ->middleware('can:settings.security.view')
            ->name('settings.security');
            
        Route::get('/notifications', NotificationSettings::class)
            ->middleware('can:settings.notifications.view')
            ->name('settings.notifications');
            
        Route::get('/system', SystemSettings::class)
            ->middleware('can:settings.system.view')
            ->name('settings.system');
    });
});
