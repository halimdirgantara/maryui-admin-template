<?php

use App\Livewire\Welcome;
use App\Livewire\Auth\Login;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Role\RoleList;
use App\Livewire\Admin\User\UserList;
use Illuminate\Support\Facades\Route;


Route::get('/login', Login::class)->name('login');

Route::middleware(['auth'])->group(function () {

    Route::get('/logout', function () {
        auth()->logout();
        return redirect()->route('login');
    })->name('logout');

    Route::get('/', Dashboard::class)->name('welcome');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/admin/user', UserList::class)->name('admin.user');
    Route::get('/admin/role', RoleList::class)->name('admin.role');
});
