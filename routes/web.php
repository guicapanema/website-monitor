<?php

use App\Http\Controllers\WebsiteController;
use App\Http\Livewire\Website\Edit as WebsiteEdit;
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

Route::get('/jobs', function() {
    \App\Models\Website::all()->each(function ($website) {
        \App\Jobs\TakeSnapshot::dispatchSync($website);
    });
});


Route::middleware(['auth'])->group(function() {
    Route::get('/', WebsiteIndex::class)->name('website.index');
    Route::get('/website/create', WebsiteEdit::class)->name('website.create');
    Route::get('/website/{website}/edit', WebsiteEdit::class)->name('website.edit');
    Route::delete('/website/{website}', [WebsiteController::class, 'destroy'])->name('website.destroy');
});

require __DIR__.'/auth.php';
