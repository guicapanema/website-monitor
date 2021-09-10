<?php

use App\Http\Livewire\Website\Index as WebsiteIndex;
use App\Http\Livewire\Website\Edit as WebsiteEdit;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(['auth'])->group(function() {
    Route::get('/', WebsiteIndex::class)->name('website.index');
    Route::get('/website/{website}/edit', WebsiteEdit::class)->name('website.edit');
});

require __DIR__.'/auth.php';
