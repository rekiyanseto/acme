<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\SubAreaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\BusinessUnitController;
use App\Http\Controllers\SurveyPeriodController;
use App\Http\Controllers\FunctionalLocationController;

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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('/')
    ->middleware('auth')
    ->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::resource('companies', CompanyController::class);
        Route::resource('business-units', BusinessUnitController::class);
        Route::resource(
            'functional-locations',
            FunctionalLocationController::class
        );
        Route::resource('areas', AreaController::class);
        Route::resource('sub-areas', SubAreaController::class);
        Route::get('equipments', [EquipmentController::class, 'index'])->name(
            'equipments.index'
        );
        Route::post('equipments', [EquipmentController::class, 'store'])->name(
            'equipments.store'
        );
        Route::get('equipments/create', [
            EquipmentController::class,
            'create',
        ])->name('equipments.create');
        Route::get('equipments/{equipment}', [
            EquipmentController::class,
            'show',
        ])->name('equipments.show');
        Route::get('equipments/{equipment}/edit', [
            EquipmentController::class,
            'edit',
        ])->name('equipments.edit');
        Route::put('equipments/{equipment}', [
            EquipmentController::class,
            'update',
        ])->name('equipments.update');
        Route::delete('equipments/{equipment}', [
            EquipmentController::class,
            'destroy',
        ])->name('equipments.destroy');

        Route::resource('categories', CategoryController::class);
        Route::resource('sub-categories', SubCategoryController::class);
        Route::resource('survey-periods', SurveyPeriodController::class);
        Route::resource('users', UserController::class);
        Route::resource('surveys', SurveyController::class);
    });
