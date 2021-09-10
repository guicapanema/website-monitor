<?php

use App\Http\Livewire\Website\Index as WebsiteIndex;
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
});

require __DIR__.'/auth.php';
