<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\SubdepartmentController;
use App\Http\Controllers\Api\DivisionController;
use App\Http\Controllers\Api\SubDivisionController;
use App\Http\Controllers\Api\PedhiController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\WorkController;
use App\Http\Controllers\Api\FirmController;
use App\Http\Controllers\Api\StaffController;
use App\Http\Controllers\Api\DailyExpenseController;
use App\Http\Controllers\Api\PartyController;
use App\Http\Controllers\Api\ContractorController;
use App\Http\Controllers\Api\SiteProgressController;
use App\Http\Controllers\Api\ToolListController;
use App\Http\Controllers\Api\ScrapMaterialController;
use App\Http\Controllers\Api\ScrapListController;
use App\Http\Controllers\Api\SiteMaterialRequirementController;
use App\Http\Controllers\Api\MaterialCategoryController;
use App\Http\Controllers\Api\MaterialListController;
use App\Http\Controllers\Api\StageController;
use App\Http\Controllers\Api\MaterialInwardController;
use App\Http\Controllers\Api\BillInwardController;
use App\Http\Controllers\Api\BillOutwardController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\WorkOrderController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\RoleController;

/*
|--------------------------------------------------------------------------
| API Routes (mobile app)
|--------------------------------------------------------------------------
| Token-based (Sanctum Bearer) JSON API consumed by the React Native app.
| Public auth endpoints first; everything else requires auth:sanctum.
| Per-action RBAC is enforced inside each controller (HasMiddleware ->
| permission:<resource>.<action>), matching the permissions.name keys.
*/

Route::prefix('v1')->group(function () {

    // --- Public ---
    Route::post('login', [AuthController::class, 'login'])->name('api.login');

    // --- Authenticated ---
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('me', [AuthController::class, 'me'])->name('api.me');
        Route::post('logout', [AuthController::class, 'logout'])->name('api.logout');

        // ---- Org structure ----
        Route::apiResource('departments', DepartmentController::class);
        Route::apiResource('sub-departments', SubdepartmentController::class);
        Route::apiResource('division', DivisionController::class);
        Route::apiResource('sub-division', SubDivisionController::class);
        Route::apiResource('pedhi', PedhiController::class);
        Route::apiResource('firms', FirmController::class);
        Route::apiResource('locations', LocationController::class);
        Route::apiResource('works', WorkController::class);

        // ---- HR / labour ----
        Route::apiResource('staff', StaffController::class);
        Route::apiResource('daily-expense', DailyExpenseController::class);

        // ---- Procurement / materials ----
        Route::apiResource('parties', PartyController::class);
        Route::apiResource('contractors', ContractorController::class);
        Route::apiResource('material-categories', MaterialCategoryController::class);
        Route::apiResource('material-lists', MaterialListController::class);
        Route::apiResource('site-material-requirements', SiteMaterialRequirementController::class);
        Route::apiResource('material-inwards', MaterialInwardController::class);

        // ---- Site ops ----
        Route::apiResource('site-progress', SiteProgressController::class);
        Route::apiResource('stages', StageController::class);
        Route::apiResource('tool-lists', ToolListController::class);
        Route::apiResource('scrap-materials', ScrapMaterialController::class);
        Route::apiResource('scrap-lists', ScrapListController::class);

        // ---- Billing & money ----
        Route::apiResource('bill-inwards', BillInwardController::class);
        Route::apiResource('bill-outwards', BillOutwardController::class);
        Route::apiResource('payments', PaymentController::class);
        Route::apiResource('work-orders', WorkOrderController::class);

        // ---- Admin ----
        Route::apiResource('users', UsersController::class);
        Route::apiResource('roles', RoleController::class);
    });
});
