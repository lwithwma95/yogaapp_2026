<?php

use App\Http\Controllers\HomePageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\YogaRegistrationController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\CadreController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Storage;




// Route::get('/', [HomePageController::class, 'live'])->name('live');

Route::get('/test-session', function () {
    session(['test' => now()]);
    return session()->getId();
});

Route::get('/', [HomePageController::class, 'index'])->name('welcome');
Route::get('/report', [HomePageController::class, 'analytics'])->name('report');

// Route::any('{any}', function () {
//     abort(404);
// })->where('any', '.*');
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::get('/createpassword/{id}', [LoginController::class, 'createPassword'])->name('create.password');
Route::post('/updatepassword', [LoginController::class, 'updatePassword'])->name('update.password');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



// Ajax Routes
Route::get('/get-blocks/{district_id}', [AjaxController::class, 'getBlocks']);
Route::get('/get-gps/{block_id}', [AjaxController::class, 'getGps']);
Route::get('/get-villages/{gp_id}', [AjaxController::class, 'getVillages']);
Route::get('/get-shgs/{vill_id}', [AjaxController::class, 'getShgs']);
Route::get('/get-members/{shg_code}', [AjaxController::class, 'getmember']);
Route::get('/get-member-details/{mem_uid}', [AjaxController::class, 'getmemberDetails']);
Route::post('/block/venue-registration/store', [BlockController::class, 'storeVenue'])->name('block.venue.store');


// Guest User Routes
Route::get('/findmembers', [YogaRegistrationController::class, 'findmembers'])->name('findmembers');
Route::post('/findmembers', [YogaRegistrationController::class, 'findmembers'])->name('yoga.findmembers');
Route::get('/yoga/registration/{mem_uid}', [YogaRegistrationController::class, 'viewMember'])->name('yoga.registration');
Route::post('/yoga/registration', [YogaRegistrationController::class, 'store'])->name('yoga.registration.store');
Route::get('/yoga/viewregistration/{mem_uid}', [YogaRegistrationController::class, 'showRegistration'])->name('yoga.registration.view');
Route::get('/searchbyshg', [YogaRegistrationController::class, 'searchbyshg'])->name('searchbyshg');
Route::post('/searchbyshg', [YogaRegistrationController::class, 'findMembersResult'])->name('yoga.findwithshgcode');
Route::post('/yoga/confirm-register', [YogaRegistrationController::class, 'confirmRegister'])->name('yoga.confirm.register');

// BLOCK DASHBOARD
Route::middleware(['auth', 'role:block'])->group(function () {
    Route::get('/block/dashboard', [DashboardController::class, 'blockDashboard'])
        ->name('block.dashboard');
    Route::get('/block/registrationsbyshg', [BlockController::class, 'viewyogaregistrations'])
        ->name('block.registrationsbyshg');
    Route::get('/block/viewallregistrations', [BlockController::class, 'viewallreg'])
        ->name('block.viewallregistrations');
    Route::get('/block/registrations/gps', [BlockController::class, 'viewRegistrationsGPWise'])->name('block.registrations.gps');
    Route::get('/block/registrations/gp/{gp_id}', [BlockController::class, 'viewRegistrationsVillageWise'])->name('block.registrations.villages');
    Route::get('/block/registrations/village/{village_id}', [BlockController::class, 'viewRegistrationsSHGWise'])->name('block.registrations.shgs');
    Route::get('/block/registrations/shg/{shg_code}', [BlockController::class, 'viewSHGRegisteredMembers'])->name('block.shg.registered');
    Route::get('/block/venueregistration', [BlockController::class, 'venueregistration'])
        ->name('block.venueregistration');
    Route::get('/block/cadrevenuemapping', [BlockController::class, 'cadrevenue'])->name('cadre.mapping');
    Route::get('/block/shgmapping', [BlockController::class, 'shgMapping'])->name('block.shgmapping');
    Route::get('/block/shgmapping/shgs/{vill_id}', [BlockController::class, 'getSHGsForMapping'])->name('block.shgmapping.shgs');
    Route::post('/block/shgmapping/save', [BlockController::class, 'saveSHGMapping'])->name('block.shgmapping.save');
    Route::get('/block/shgmapping/venue/{venue_id}', [BlockController::class, 'shgMappingVenue'])->name('block.shgmapping.venue');
    Route::post('/block/shgmapping/venue/save', [BlockController::class, 'saveShgVenueMapping'])->name('block.shgmapping.venue.save');
    Route::get('/block/viewmappedshgs4yoga/{village_id}', [BlockController::class, 'mappedShgs'])->name('block.viewmappedshgs');
    Route::get('/block/venue/by-member/{mem_code}', [BlockController::class, 'getVenuesByMember'])->name('block.venue.by-member');
    Route::post('/block/venue/update', [BlockController::class, 'updateVenue'])->name('block.venue.update');
    Route::post('/block/venue/update-cadre', [BlockController::class, 'updateVenueCadre'])->name('block.venue.update-cadre');
    Route::post('/block/venue/delete', [BlockController::class, 'deleteVenue'])->name('block.venue.delete');

});

// CADRE DASHBOARD
Route::middleware(['auth', 'role:cadre'])->group(function () {

    Route::get('/cadre/dashboard', [DashboardController::class, 'cadreDashboard'])->name('cadre.dashboard');

    Route::get('/cadre/viewregister', [CadreController::class, 'viewShgMembers'])->name('cadre.shgmembers');
    Route::get('/cadre/addattendance/{shg_code}', [CadreController::class, 'addattendance'])
    ->name('add.yoga.attendance');
    Route::post('/attendance/store', [CadreController::class, 'storeAttendance'])->name('cadre.attendance.store');
    Route::get('/cadre/attendance', [CadreController::class, 'viewShgs'])->name('cadre.shg');
    Route::get('/cadre/upload-venue-photo', [CadreController::class, 'showUploadVenuePhoto'])->name('cadre.upload.venue.photo');
    Route::post('/cadre/upload-venue-photo', [CadreController::class, 'storeVenuePhoto'])->name('cadre.upload.venue.photo.store');
    Route::delete('cadre/venue/photo/delete', [CadreController::class, 'deletephoto'])
     ->name('cadre.delete.venue.photo');
    Route::get('/cadre/registeredmembers/{shg_code}', [CadreController::class,'registeredmemberdetails'])
    ->name('cadre.viewregistered.members');
});


// DISTRICT DASHBOARD
Route::middleware(['auth', 'role:district'])->group(function () {
    Route::get('/district/dashboard', [DistrictController::class, 'dashboard'])
        ->name('district.dashboard');
    Route::get('/district/registration', [DistrictController::class, 'registration'])->name('district.registrations');
    Route::get('/district/block/{block_id}', [DistrictController::class, 'blockDetails'])
        ->name('district.block.details');
    Route::get('/district/gp/{gp_id}', [DistrictController::class, 'gpDetails'])
        ->name('district.gp.details');
    Route::get('/district/village/{village_id}', [DistrictController::class, 'villageDetails'])
        ->name('district.village.details');
    Route::get('/district/shg/{shg_code}/registered', [DistrictController::class, 'shgRegisteredMembers'])->name('district.shg.registered');

    Route::get('/district/cadrevenuemapping', [DistrictController::class, 'cadreVenueMapping'])->name('district.cadrevenuemapping');
    Route::get('/district/cadrevenuemapping/gp/{block_id}', [DistrictController::class, 'cadreVenueMappingBlock'])->name('district.cvm.block');
    Route::get('/district/cadrevenuemapping/village/{gp_id}', [DistrictController::class, 'cadreVenueMappingGp'])->name('district.cvm.gp');
    Route::get('/district/cadrevenuemapping/venue/{village_id}', [DistrictController::class, 'cadreVenueMappingVillage'])->name('district.cvm.village');
    Route::get('/district/cadrevenuemapping/venue/{venue_id}/shg', [DistrictController::class, 'mappedshg'])->name('district.cvm.venue.shg');
    Route::get('/district/mappedshg/{venue_id}', [DistrictController::class,'mappedshg'])->name('district.mappedshg');



    // District user management (block users)
    Route::get('/district/users', [UserManagementController::class, 'districtUsers'])->name('district.users.index');
    Route::get('/district/users/create', [UserManagementController::class, 'districtCreateUser'])->name('district.users.create');
    Route::post('/district/users/store', [UserManagementController::class, 'districtStoreUser'])->name('district.users.store');
    Route::get('/district/users/edit/{id}', [UserManagementController::class, 'districtEditUser'])->name('district.users.edit');
    Route::post('/district/users/update/{id}', [UserManagementController::class, 'districtUpdateUser'])->name('district.users.update');
    Route::post('/district/users/reset-password/{id}', [UserManagementController::class, 'districtResetPassword'])->name('district.users.reset-password');
});


// STATE DASHBOARD
Route::middleware(['auth', 'role:state'])->group(function () {
    Route::get('/state/dashboard', [StateController::class, 'dashboard'])
        ->name('state.dashboard');
    Route::get('/state/district/{district_id}', [StateController::class, 'districtDetails'])
        ->name('state.district.details');
    Route::get('/state/block/{block_id}', [StateController::class, 'blockDetails'])
        ->name('state.block.details');
    Route::get('/state/gp/{gp_id}', [StateController::class, 'gpDetails'])
        ->name('state.gp.details');
    Route::get('/state/village/{village_id}', [StateController::class, 'villageDetails'])
        ->name('state.village.details');
    Route::get('/state/shg/{shg_code}', [StateController::class, 'shgDetails'])
        ->name('state.shg.details');
    Route::get('/state/shg/{shg_code}/registered', [StateController::class, 'shgRegisteredMembers'])->name('state.shg.registered');

    Route::get('/state/registration', [StateController::class, 'allregistration'])->name('state.registrations');

    Route::get('/state/cadrevenuemapping', [StateController::class, 'cadreVenueMapping'])->name('state.cadrevenuemapping');
    Route::get('/state/cadrevenuemapping/district/{district_id}', [StateController::class, 'cadreVenueMappingDistrict'])->name('state.cvm.district');
    Route::get('/state/cadrevenuemapping/block/{block_id}', [StateController::class, 'cadreVenueMappingBlock'])->name('state.cvm.block');
    Route::get('/state/cadrevenuemapping/gp/{gp_id}', [StateController::class, 'cadreVenueMappingGp'])->name('state.cvm.gp');
    Route::get('/state/cadrevenuemapping/village/{village_id}', [StateController::class, 'cadreVenueMappingVillage'])->name('state.cvm.village');

    // State user management (district users)
    Route::get('/state/users', [UserManagementController::class, 'stateUsers'])->name('state.users.index');
    Route::get('/state/users/create', [UserManagementController::class, 'stateCreateUser'])->name('state.users.create');
    Route::post('/state/users/store', [UserManagementController::class, 'stateStoreUser'])->name('state.users.store');
    Route::get('/state/users/edit/{id}', [UserManagementController::class, 'stateEditUser'])->name('state.users.edit');
    Route::post('/state/users/update/{id}', [UserManagementController::class, 'stateUpdateUser'])->name('state.users.update');
    Route::post('/state/users/reset-password/{id}', [UserManagementController::class, 'stateResetPassword'])->name('state.users.reset-password');
});