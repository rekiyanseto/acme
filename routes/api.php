<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AreaController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PhotoController;
use App\Http\Controllers\Api\SurveyController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\SubAreaController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EquipmentController;
use App\Http\Controllers\Api\SettlementController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\SubCategoryController;
use App\Http\Controllers\Api\InitialTestController;
use App\Http\Controllers\Api\BusinessUnitController;
use App\Http\Controllers\Api\AreaSubAreasController;
use App\Http\Controllers\Api\SurveyPeriodController;
use App\Http\Controllers\Api\SurveyPhotosController;
use App\Http\Controllers\Api\SurveyResultController;
use App\Http\Controllers\Api\SubAreaSurveysController;
use App\Http\Controllers\Api\EquipmentSurveysController;
use App\Http\Controllers\Api\SubAreaEquipmentsController;
use App\Http\Controllers\Api\SurveySettlementsController;
use App\Http\Controllers\Api\FunctionalLocationController;
use App\Http\Controllers\Api\SubCategorySurveysController;
use App\Http\Controllers\Api\SurveyInitialTestsController;
use App\Http\Controllers\Api\SurveyPeriodSurveysController;
use App\Http\Controllers\Api\SurveySurveyResultsController;
use App\Http\Controllers\Api\MaintenanceDocumentController;
use App\Http\Controllers\Api\CompanyBusinessUnitsController;
use App\Http\Controllers\Api\CategorySubCategoriesController;
use App\Http\Controllers\Api\FunctionalLocationAreasController;
use App\Http\Controllers\Api\SettlementByBusinessUnitController;
use App\Http\Controllers\Api\SubAreaMaintenanceDocumentsController;
use App\Http\Controllers\Api\EquipmentMaintenanceDocumentsController;
use App\Http\Controllers\Api\BusinessUnitFunctionalLocationsController;
use App\Http\Controllers\Api\SurveySettlementByBusinessUnitsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('companies', CompanyController::class);

        // Company Business Units
        Route::get('/companies/{company}/business-units', [
            CompanyBusinessUnitsController::class,
            'index',
        ])->name('companies.business-units.index');
        Route::post('/companies/{company}/business-units', [
            CompanyBusinessUnitsController::class,
            'store',
        ])->name('companies.business-units.store');

        Route::apiResource('business-units', BusinessUnitController::class);

        // BusinessUnit Functional Locations
        Route::get('/business-units/{businessUnit}/functional-locations', [
            BusinessUnitFunctionalLocationsController::class,
            'index',
        ])->name('business-units.functional-locations.index');
        Route::post('/business-units/{businessUnit}/functional-locations', [
            BusinessUnitFunctionalLocationsController::class,
            'store',
        ])->name('business-units.functional-locations.store');

        Route::apiResource(
            'functional-locations',
            FunctionalLocationController::class
        );

        // FunctionalLocation Areas
        Route::get('/functional-locations/{functionalLocation}/areas', [
            FunctionalLocationAreasController::class,
            'index',
        ])->name('functional-locations.areas.index');
        Route::post('/functional-locations/{functionalLocation}/areas', [
            FunctionalLocationAreasController::class,
            'store',
        ])->name('functional-locations.areas.store');

        Route::apiResource('areas', AreaController::class);

        // Area Sub Areas
        Route::get('/areas/{area}/sub-areas', [
            AreaSubAreasController::class,
            'index',
        ])->name('areas.sub-areas.index');
        Route::post('/areas/{area}/sub-areas', [
            AreaSubAreasController::class,
            'store',
        ])->name('areas.sub-areas.store');

        Route::apiResource('sub-areas', SubAreaController::class);

        // SubArea Equipments
        Route::get('/sub-areas/{subArea}/equipments', [
            SubAreaEquipmentsController::class,
            'index',
        ])->name('sub-areas.equipments.index');
        Route::post('/sub-areas/{subArea}/equipments', [
            SubAreaEquipmentsController::class,
            'store',
        ])->name('sub-areas.equipments.store');

        // SubArea Surveys
        Route::get('/sub-areas/{subArea}/surveys', [
            SubAreaSurveysController::class,
            'index',
        ])->name('sub-areas.surveys.index');
        Route::post('/sub-areas/{subArea}/surveys', [
            SubAreaSurveysController::class,
            'store',
        ])->name('sub-areas.surveys.store');

        // SubArea Maintenance Documents
        Route::get('/sub-areas/{subArea}/maintenance-documents', [
            SubAreaMaintenanceDocumentsController::class,
            'index',
        ])->name('sub-areas.maintenance-documents.index');
        Route::post('/sub-areas/{subArea}/maintenance-documents', [
            SubAreaMaintenanceDocumentsController::class,
            'store',
        ])->name('sub-areas.maintenance-documents.store');

        Route::apiResource('equipments', EquipmentController::class);

        // Equipment Surveys
        Route::get('/equipments/{equipment}/surveys', [
            EquipmentSurveysController::class,
            'index',
        ])->name('equipments.surveys.index');
        Route::post('/equipments/{equipment}/surveys', [
            EquipmentSurveysController::class,
            'store',
        ])->name('equipments.surveys.store');

        // Equipment Maintenance Documents
        Route::get('/equipments/{equipment}/maintenance-documents', [
            EquipmentMaintenanceDocumentsController::class,
            'index',
        ])->name('equipments.maintenance-documents.index');
        Route::post('/equipments/{equipment}/maintenance-documents', [
            EquipmentMaintenanceDocumentsController::class,
            'store',
        ])->name('equipments.maintenance-documents.store');

        Route::apiResource('categories', CategoryController::class);

        // Category Sub Categories
        Route::get('/categories/{category}/sub-categories', [
            CategorySubCategoriesController::class,
            'index',
        ])->name('categories.sub-categories.index');
        Route::post('/categories/{category}/sub-categories', [
            CategorySubCategoriesController::class,
            'store',
        ])->name('categories.sub-categories.store');

        Route::apiResource('sub-categories', SubCategoryController::class);

        // SubCategory Surveys
        Route::get('/sub-categories/{subCategory}/surveys', [
            SubCategorySurveysController::class,
            'index',
        ])->name('sub-categories.surveys.index');
        Route::post('/sub-categories/{subCategory}/surveys', [
            SubCategorySurveysController::class,
            'store',
        ])->name('sub-categories.surveys.store');

        Route::apiResource('survey-periods', SurveyPeriodController::class);

        // SurveyPeriod Surveys
        Route::get('/survey-periods/{surveyPeriod}/surveys', [
            SurveyPeriodSurveysController::class,
            'index',
        ])->name('survey-periods.surveys.index');
        Route::post('/survey-periods/{surveyPeriod}/surveys', [
            SurveyPeriodSurveysController::class,
            'store',
        ])->name('survey-periods.surveys.store');

        Route::apiResource('users', UserController::class);

        Route::apiResource('surveys', SurveyController::class);

        // Survey Settlements
        Route::get('/surveys/{survey}/settlements', [
            SurveySettlementsController::class,
            'index',
        ])->name('surveys.settlements.index');
        Route::post('/surveys/{survey}/settlements', [
            SurveySettlementsController::class,
            'store',
        ])->name('surveys.settlements.store');

        // Survey Photos
        Route::get('/surveys/{survey}/photos', [
            SurveyPhotosController::class,
            'index',
        ])->name('surveys.photos.index');
        Route::post('/surveys/{survey}/photos', [
            SurveyPhotosController::class,
            'store',
        ])->name('surveys.photos.store');

        // Survey Initial Tests
        Route::get('/surveys/{survey}/initial-tests', [
            SurveyInitialTestsController::class,
            'index',
        ])->name('surveys.initial-tests.index');
        Route::post('/surveys/{survey}/initial-tests', [
            SurveyInitialTestsController::class,
            'store',
        ])->name('surveys.initial-tests.store');

        // Survey Survey Results
        Route::get('/surveys/{survey}/survey-results', [
            SurveySurveyResultsController::class,
            'index',
        ])->name('surveys.survey-results.index');
        Route::post('/surveys/{survey}/survey-results', [
            SurveySurveyResultsController::class,
            'store',
        ])->name('surveys.survey-results.store');

        // Survey Settlement By Business Units
        Route::get('/surveys/{survey}/settlement-by-business-units', [
            SurveySettlementByBusinessUnitsController::class,
            'index',
        ])->name('surveys.settlement-by-business-units.index');
        Route::post('/surveys/{survey}/settlement-by-business-units', [
            SurveySettlementByBusinessUnitsController::class,
            'store',
        ])->name('surveys.settlement-by-business-units.store');
    });
