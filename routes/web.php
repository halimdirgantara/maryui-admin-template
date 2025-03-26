<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Role\RoleList;
use App\Livewire\Admin\User\UserList;
use App\Livewire\Admin\Permission\PermissionList;


Route::get('/login', Login::class)->name('login');

Route::middleware(['auth'])->group(function () {

    Route::get('/logout', function () {
        auth()->logout();
        return redirect()->route('login');
    })->name('logout');

    Route::get('/', Dashboard::class)->name('welcome');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/user-management/user', UserList::class)->name('user-management.user');
    Route::get('/user-management/role', RoleList::class)->name('user-management.role');
    Route::get('/user-management/permission', PermissionList::class)->name('user-management.permission');
});
