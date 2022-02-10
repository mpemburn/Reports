<?php

use App\Http\Controllers\LivewireController;
use App\Http\Controllers\ReportController;
use App\Models\User;
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

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/import', function () {
//    $service = new \App\Services\TogglService();
//    $service->importFromApi();
//    !d($service->getEntries());
//
//});

//Route::get('/token', function () {
//    $user = User::find(1);
//    $user->createToken('AuthToken')->accessToken;
//
//});

Route::get('/git', function () {
    $locals = storage_path('app/public/data/') . 'locals.txt';
    $localsData = collect(explode("\n", file_get_contents($locals)));
    $remotes = storage_path('app/public/data/') . 'remotes.txt';
    $remotesData = collect(explode("\n", file_get_contents($remotes)));

    if ($remotesData->contains('bugfix/TRAK-150-present-settings-option-name')) {
        echo 'It does';
    }

    $localsData->each(function ($branch) use ($remotesData) {
        $remotesData->contains(function ($value, $key) use ($branch) {
            return $value !== $branch;
        });
    });

});


Route::group(['middleware' => 'auth'], function(){
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/reports', ReportController::class . '@index')->name('reports');
    Route::get('/livewire', LivewireController::class . '@index')->name('livewire');
});

require __DIR__.'/auth.php';
