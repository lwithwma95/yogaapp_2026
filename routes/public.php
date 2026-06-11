<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\YogaRegistrationController;

// Home
Route::get('/', [HomePageController::class, 'index'])->name('welcome');
Route::get('/report', [HomePageController::class, 'analytics'])->name('report');



// Ajax
Route::get('/get-blocks/{district_id}', [AjaxController::class, 'getBlocks']);
Route::get('/get-gps/{block_id}', [AjaxController::class, 'getGps']);
Route::get('/get-villages/{gp_id}', [AjaxController::class, 'getVillages']);
Route::get('/get-shgs/{vill_id}', [AjaxController::class, 'getShgs']);
Route::get('/get-members/{shg_code}', [AjaxController::class, 'getmember']);
Route::get('/get-member-details/{mem_uid}', [AjaxController::class, 'getmemberDetails']);
Route::get('/get-shg-mapped/{vill_id}', [AjaxController::class,'getShgsVenueMapped']);
Route::post('/check-venue-monitor', [AjaxController::class, 'checkVenueMonitor']);
Route::post('/check-village-venue', [AjaxController::class, 'checkVillageVenue']);

// Public Registration
Route::get('/findmembers', [YogaRegistrationController::class, 'findmembers'])->name('findmembers');
Route::post('/findmembers', [YogaRegistrationController::class, 'findmembers'])->name('yoga.findmembers');

Route::get('/searchbyshg', [YogaRegistrationController::class, 'searchbyshg'])->name('searchbyshg');
Route::post('/searchbyshg', [YogaRegistrationController::class, 'findMembersResult'])->name('yoga.findwithshgcode');

Route::get('/yoga/registration/{mem_uid}', [YogaRegistrationController::class, 'viewMember'])->name('yoga.registration');

Route::post('/yoga/registration', [YogaRegistrationController::class, 'store'])->name('yoga.registration.store');

Route::post('/yoga/confirm-register', [YogaRegistrationController::class, 'confirmRegister'])->name('yoga.confirm.register');

Route::get('/yoga/viewregistration/{mem_uid}', [YogaRegistrationController::class, 'showRegistration'])->name('yoga.registration.view');