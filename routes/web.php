<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\DashboardController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SubdepartmentController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\SubDivisionController;
use App\Http\Controllers\PedhiController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\FirmController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DailyExpenseController;
use App\Http\Controllers\PaymentSlabController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\ContractorController;
use App\Http\Controllers\SiteProgressController;
use App\Http\Controllers\ToolListController;
use App\Http\Controllers\GstBillListController;
use App\Http\Controllers\ScrapMaterialController;
use App\Http\Controllers\ScrapListController;
use App\Http\Controllers\SiteMaterialRequirementController;
use App\Http\Controllers\MaterialCategoryController;
use App\Http\Controllers\MaterialListController;
use App\Http\Controllers\MaterialInwardController;
use App\Http\Controllers\BillInwardController;
use App\Http\Controllers\BillOutwardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StageController;
// Route::get('/', function () {
//     return view('admin.auth.login');
// });


Route::get('/', [LoginController::class, 'showLoginForm'])->name('login')->middleware('redirectIfAuthenticated');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('redirectIfAuthenticated');
Route::post('/login', [LoginController::class, 'login'])->name('post.login');
Route::middleware(['auth', 'staff.permission'])->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('users', UsersController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('sub-departments', SubdepartmentController::class);
    Route::get('division/get-subdepartments', [DivisionController::class, 'getSubdepartments'])->name('division.getSubdepartments');
    Route::resource('division', DivisionController::class);
    Route::resource('sub-division', SubDivisionController::class);
    Route::resource('pedhi', PedhiController::class);
    Route::get('locations/get-subdepartments', [LocationController::class, 'getSubdepartments'])->name('locations.getSubdepartments');
    Route::get('locations/get-divisions', [LocationController::class, 'getDivisions'])->name('locations.getDivisions');
    Route::get('locations/get-sub-divisions', [LocationController::class, 'getSubDivisions'])->name('locations.getSubDivisions');
    Route::resource('locations', LocationController::class);

    Route::get('works/get-subdepartments', [WorkController::class, 'getSubdepartments'])->name('works.getSubdepartments');
    Route::get('works/get-divisions', [WorkController::class, 'getDivisions'])->name('works.getDivisions');
    Route::get('works/get-sub-divisions', [WorkController::class, 'getSubDivisions'])->name('works.getSubDivisions');
    Route::get('works/get-locations', [WorkController::class, 'getLocations'])->name('works.getLocations');
    Route::resource('works', WorkController::class);

    Route::resource('firms', FirmController::class);

    Route::resource('staff', StaffController::class);
    
    // Attendance routes
    Route::post('attendance/update', [AttendanceController::class, 'update'])->name('attendance.update');
    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('attendance/get', [AttendanceController::class, 'getAttendance'])->name('attendance.get');
    Route::get('attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');

    // Daily Expense routes
    Route::resource('daily-expense', DailyExpenseController::class);


    Route::resource('parties', PartyController::class);

    Route::get('contractors/get-works-by-locations', [ContractorController::class, 'getWorksByLocations'])->name('contractors.getWorksByLocations');
    Route::resource('contractors', ContractorController::class);

    Route::get('site-progress/get-works-by-location', [SiteProgressController::class, 'getWorksByLocation'])->name('site-progress.getWorksByLocation');
    Route::resource('site-progress', SiteProgressController::class);

    Route::resource('tool-lists', ToolListController::class);


    Route::resource('scrap-materials', ScrapMaterialController::class);

    Route::resource('scrap-lists', ScrapListController::class);

    Route::get('site-material-requirements/get-materials-by-category', [SiteMaterialRequirementController::class, 'getMaterialsByCategory'])->name('site-material-requirements.getMaterialsByCategory');
    Route::get('site-material-requirements/get-works-by-location', [SiteMaterialRequirementController::class, 'getWorksByLocation'])->name('site-material-requirements.getWorksByLocation');
    Route::resource('site-material-requirements', SiteMaterialRequirementController::class);

    Route::resource('material-categories', MaterialCategoryController::class);
    Route::resource('material-lists', MaterialListController::class);
    Route::resource('stages', StageController::class);
    
    Route::get('material-inwards/get-party-details', [MaterialInwardController::class, 'getPartyDetails'])->name('material-inwards.getPartyDetails');
    Route::get('material-inwards/get-works-by-location', [MaterialInwardController::class, 'getWorksByLocation'])->name('material-inwards.getWorksByLocation');
    Route::get('material-inwards/get-materials-by-party', [MaterialInwardController::class, 'getMaterialsByParty'])->name('material-inwards.getMaterialsByParty');
    Route::resource('material-inwards', MaterialInwardController::class);
    
    Route::get('bill-inwards/get-party-details', [BillInwardController::class, 'getPartyDetails'])->name('bill-inwards.getPartyDetails');
    Route::get('bill-inwards/get-materials-by-party', [BillInwardController::class, 'getMaterialsByParty'])->name('bill-inwards.getMaterialsByParty');
    Route::resource('bill-inwards', BillInwardController::class);
    
    Route::get('bill-outwards/get-party-details', [BillOutwardController::class, 'getPartyDetails'])->name('bill-outwards.getPartyDetails');
    Route::get('bill-outwards/get-materials-by-party', [BillOutwardController::class, 'getMaterialsByParty'])->name('bill-outwards.getMaterialsByParty');
    Route::get('bill-outwards/get-works-by-party', [BillOutwardController::class, 'getWorksByParty'])->name('bill-outwards.getWorksByParty');
    Route::resource('bill-outwards', BillOutwardController::class);
    
    Route::get('payments/get-staff-payable', [PaymentController::class, 'getStaffPayable'])->name('payments.getStaffPayable');
    Route::get('payments/get-party-bills', [PaymentController::class, 'getPartyBills'])->name('payments.getPartyBills');
    Route::get('payments/get-vendor-bills', [PaymentController::class, 'getVendorBills'])->name('payments.getVendorBills');
    Route::resource('payments', PaymentController::class);

    Route::get('my-profile', [ProfileController::class, 'index'])->name('user.getProfile');
    Route::get('edit-profile', [ProfileController::class, 'edit'])->name('user.editProfile');
    Route::put('edit-profile/{id}', [ProfileController::class, 'update'])->name('user.updateProfile');
    Route::get('change-password', [ProfileController::class, 'changePassword'])->name('user.changePassword');
    Route::post('change-password', [ProfileController::class, 'updatePassword'])->name('user.updatePassword');
});
