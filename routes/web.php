<?php

use App\Livewire\Welcome;
use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;

Route::get('/', Welcome::class);

Route::get('/login', Login::class)->name('login');
