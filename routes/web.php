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
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DailyExpenseController;
use App\Http\Controllers\PaymentSlabController;
use App\Http\Controllers\SiteMaterialController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\ContractorController;
use App\Http\Controllers\SiteProgressController;
use App\Http\Controllers\ToolListController;
use App\Http\Controllers\GstBillListController;
use App\Http\Controllers\ScrapMaterialController;
use App\Http\Controllers\ScrapListController;
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

    Route::resource('staff', StaffController::class);
    
    // Attendance routes
    Route::post('attendance/update', [AttendanceController::class, 'update'])->name('attendance.update');
    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('attendance/get', [AttendanceController::class, 'getAttendance'])->name('attendance.get');

    // Daily Expense routes
    Route::resource('daily-expense', DailyExpenseController::class);

    Route::resource('payment-slabs', PaymentSlabController::class);

    Route::resource('site-materials', SiteMaterialController::class);

    Route::resource('parties', PartyController::class);

    Route::resource('contractors', ContractorController::class);

    Route::resource('site-progress', SiteProgressController::class);

    Route::resource('tool-lists', ToolListController::class);

    Route::resource('gst-bill-lists', GstBillListController::class);

    Route::resource('scrap-materials', ScrapMaterialController::class);

    Route::resource('scrap-lists', ScrapListController::class);

    Route::get('my-profile', [ProfileController::class, 'index'])->name('user.getProfile');
    Route::get('edit-profile', [ProfileController::class, 'edit'])->name('user.editProfile');
    Route::put('edit-profile/{id}', [ProfileController::class, 'update'])->name('user.updateProfile');
    Route::get('change-password', [ProfileController::class, 'changePassword'])->name('user.changePassword');
    Route::post('change-password', [ProfileController::class, 'updatePassword'])->name('user.updatePassword');
});
