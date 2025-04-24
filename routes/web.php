<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TutorialController;
use App\Http\Controllers\TutorialDetailController;
use App\Http\Controllers\PublicTutorialController;
use App\Http\Controllers\Api\TutorialApiController;
use App\Models\Tutorial;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');  //homepage login
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/admin', [TutorialController::class, 'adminDashboard'])     //homepage admin
    ->middleware('auth.session')
    ->name('admin.dashboard');

Route::resource('/tutorials', TutorialController::class)    //homepage manajemen tutorial
    ->middleware('auth.session');

Route::resource('/tutorials/{tutorial}/details', TutorialDetailController::class)   //homepage detail tutorial
    ->names('details')
    ->middleware('auth.session');

Route::get('/presentation/{slug}/{unique_filename}', [PublicTutorialController::class, 'showPresentation'])->name('public.presentation');  //page presentasi
Route::get('/finished/{slug}/{unique_filename_finished}', [PublicTutorialController::class, 'generatePdf'])->name('public.finished');

Route::get('/api/{kode_makul}', [TutorialApiController::class, 'byMataKuliah']);    //endpoint webservice server

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');  //logout

Route::get('/', function () {
    $tutorials = Tutorial::latest()->get();
    return view('home', compact('tutorials'));
});
